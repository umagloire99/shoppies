<?php

use App\Models\OrderTransaction;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Services\CartService;
use App\Services\Shipping;
use Artesaos\SEOTools\Facades\SEOTools;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;
use Spatie\Valuestore\Valuestore;
use Faker\Factory;

function clear_cache(): void
{
    Cache::forget('shop_categories_menu');
    Cache::forget('shop_tags_menu');
    Cache::forget('recent_reviews');
}
if (!function_exists('generateFakeEmail')) {
    function generateFakeEmail(): string
    {
        $faker = Factory::create();
        $email = $faker->email;
        if (User::whereEmail($email)->exists()) {
            return generateFakeEmail();
        }
        return $email;
    }
}
if (!function_exists('generateUsername')) {
    function generateUsername($email)
    {
        $username = explode('@', $email)[0];
        if ($user = User::whereUsername($username)->first()) {
            $username = $user->username . $user->id;
            return generateUsername($username);
        } else {
            return $username;
        }
    }
}

/**
 * @return false|string
 */
function generateTransactionId()
{
    $chars = '0123456789';
    $code = substr(str_shuffle($chars), 0, 7);

    if (OrderTransaction::whereTransactionNumber($code)->exists()) {
        return generateTransactionId();
    } else {
        return $code;
    }
}

function getSettingsOf(string $key)
{
    $settings = Valuestore::make(config_path('settings.json'));
    return $settings->get($key);
}

/**
 * @return array
 */
function getMomoToken(): array
{
    $token = PaymentMethod::whereCode('MOMO')->first();
    if (!$token->access_token || ($token->expires_at && $token->expires_at->isPast())) {
        $response = http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => config('services.momo.subscription_key'),
            'Authorization' => 'Basic ' .
                base64_encode(config('services.momo.collection_id') . ':' . config('services.momo.collection_secret')),
        ])->post(config('services.momo.token_uri'));
        $result = json_decode($response->body(), true);
        if ($response->successful()) {
            $token->expires_at = Carbon::now()->addSeconds($result['expires_in']);
            $token->access_token = $result['access_token'];
            $token->save();
            return ['success' => true, 'access_token' => $result['access_token']];
        } else {
            return ['success' => true, 'message' => __('general.try-again-later')];
        }
    } else {
        return ['success' => true, 'access_token' => $token->access_token];
    }
}

/**
 * @param $detail
 * @param $phone
 * @return array
 */
function initializeMoMoPayment($detail, $phone): array
{
    $shippingInfo = new Shipping($detail);
    $shippingInfo->saveUserShippingAddress();
    $cart = collect((new CartService())->cartContent());
    $amount = $shippingInfo->shippingAgency ? $shippingInfo->shippingAgency->cost + $cart->sum('discount_price')
        : $cart->sum('discount_price');
    $momoTransactionId = Uuid::uuid4()->toString();
    $token = getMomoToken();
    if (!$token['success']) {
        return $token;
    }
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Ocp-Apim-Subscription-Key' => config('services.momo.subscription_key'),
        'X-Target-Environment' => "mtncameroon",
        'Authorization' => 'Bearer ' . $token['access_token'],
        'X-Reference-Id' => $momoTransactionId,
        'X-Callback-Url' => config('services.momo.callback_uri')
    ])->post(config('services.momo.transaction_status_uri'), [
        "amount" => $amount,
        "currency" => "XAF",
        "externalId" => $shippingInfo->username,
        "payer" => [
            "partyIdType" => "MSISDN",
            "partyId" => "237$phone"
        ],
        "payerMessage" => 'Payment initiated',
        "payeeNote" => 'payment initiated'
    ]);
    Log::error($response->body());
    if ($response->successful()) {
        (new CartService())->save($shippingInfo->username);
        return [
            'status' => 'PENDING',
            'paymentId' => $momoTransactionId,
            'message' => __('general.dial', ['ussd' => '*126#'])
        ];
    } else {
        return ['status' => 'FAILED', 'message' => __('general.try-again-later')];
    }
}

/**
 * @param string | null $title
 * @param string | null $description
 * @param $img
 */
function setMetaInfo(string $title = null, string $description = null, $img = null)
{
    if (!$title) {
        $title = config('app.name', 'HappyCute');
    }
    if (!$description) {
        $description = __('general.about');
    }
    if (!$img) {
        $img = asset('img/logo.png');
    }
    SEOTools::setTitle($title);
    SEOTools::setDescription($description);
    SEOTools::addImages([$img]);
    SEOTools::opengraph()->addImage($img);
}

function momoTransactionStatus($paymentId)
{
    $token = getMomoToken();
    if (!$token['success']) {
        return $token;
    }
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'Ocp-Apim-Subscription-Key' => config('services.momo.subscription_key'),
        'X-Target-Environment' => config('services.momo.environment'),
        'Authorization' => 'Bearer ' . $token['access_token'],
    ])->get(config('services.momo.transaction_status_uri') . "/${paymentId}");
    $result = json_decode($response->body(), true);
    Log::error($result);
    $order = null;
    if ($response->successful()) {
        $status = 'FAILED';
        if ($result['status'] == 'FAILED') {
            $reason_code = $result['reason'];
            if ($reason_code == "PAYER_NOT_FOUND") {
                $message = __('general.no_momo');
            } else if ($reason_code == "NOT_ENOUGH_FUNDS") {
                $message = __('general.momo_insufficient');
            } elseif ($reason_code == 'EXPIRED') {
                $message = __('general.momo_expired');
            } elseif ($reason_code == 'TRANSACTION_CANCELED') {
                $message = __('general.momo_cancelled');
            } else {
                $message = __('general.try-again-later');
            }
        } elseif ($result['status'] == 'SUCCESSFUL') {
            $status = 'COMPLETE';
            $message = 'You order has been successfully placed';
            $t = OrderTransaction::whereExternalNumber($result['financialTransactionId'])->first();
            if (!$t) {
                $order = (new CartService())->savePaidOrder($result['financialTransactionId'],
                    $result["externalId"], PaymentMethod::whereCode('MOMO')->first(), $result);
            } else {
                $order = $t->order;
            }
        } else {
            $status = 'PENDING';
            $message = __('general.dial', ['ussd' => '*126#']);
        }
        return [
            'status' => $status,
            'message' => $message,
            'paymentId' => $paymentId,
            'order' => $order,
        ];
    } else {
        return ['status' => 'FAILED', 'message' => __('general.try-again-later')];
    }
}

if (!function_exists('monetbil')) {

    /**
     * initiate monetbil payment
     * @param $detail
     * @param $phone
     * @return mixed
     */
    function monetbil($detail, $phone)
    {
        $shippingInfo = new Shipping($detail);
        $shippingInfo->saveUserShippingAddress();
        $cart = collect((new CartService())->cartContent());

        $url = "https://api.monetbil.com/payment/v1/placePayment";
        $data = [
            'amount' => $shippingInfo->shippingAgency ? $shippingInfo->shippingAgency->cost + $cart->sum('discount_price') : $cart->sum('discount_price'), //single token
            'phonenumber' => $phone,
            'currency' => "XAF",
            'item_ref' => json_encode($cart->toArray()),
            'service' => config('services.monetbil.service_key'),
            'country' => "CM",
            'user' => $shippingInfo->username,
            'first_name' => $shippingInfo->name,
            'email' => $shippingInfo->email,
            'notify_url' => route('api.monetbil.notify')
        ];

        $payload = json_encode($data);
        // Prepare new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $result = curl_exec($ch);
        $result = json_decode($result, true);

        if ($result && $result['status'] == "REQUEST_ACCEPTED") {
            $result = [
                'status' => 'PENDING',
                'message' => __('general.dial', ['ussd' => $result['channel_ussd']]),
                'paymentId' => $result['paymentId']
            ];
        } else {
            $result = [
                'status' => 'FAILED',
                'message' => __('general.try-again-later'),
                'error' => __('general.try-again-later'),
            ];
        }
        return $result;
    }
}

if (!function_exists('monetbilHook')) {
    /**
     * @param $paymentId
     * @return array
     */
    function monetbilHook($paymentId): array
    {
        $data = array(
            'service' => config('services.monetbil.service_key'),
            'paymentId' => $paymentId
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.monetbil.com/payment/v1/checkPayment');
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        $json = curl_exec($ch);
        $jsonArray = json_decode($json, true);
        Log::error($jsonArray);
        $order = null;
        try {
            $message = $jsonArray['message'];
        } catch (Exception $exception) {
            $message = __('general.try-again-later');
        };
        if (is_array($jsonArray) and array_key_exists('transaction', $jsonArray)) {
            $status = 'PENDING';
            $transaction = $jsonArray['transaction'];
            $transaction_id = $transaction['transaction_UUID'];
            if ($transaction['status'] == 1) {
                $status = 'COMPLETE';
                $orderTransaction = OrderTransaction::whereExternalNumber($transaction_id)->first();
                if (!$orderTransaction) {
                    $order = (new CartService())->savePaidOrder($transaction_id, $transaction['user'],
                        PaymentMethod::whereCode('MONETBIL')->first(), $jsonArray['transaction']);
                } else {
                    $order = $orderTransaction->order;
                }
            } elseif ($transaction['status'] == -1) {
                $status = 'FAILED';
                $message = __('general.momo_cancelled');
            } else {
                if ($transaction['message'] == "Waiting time expired.") {
                    $status = 'FAILED';
                    $message = __('general.momo_expired');
                }
                if ($transaction['message'] == "TARGET_AUTHORIZATION_ERROR") {
                    $status = 'FAILED';
                    $message = __('general.momo_insufficient');
                }
            }
        } else {
            if ($jsonArray['message'] == 'payment pending') {
                $status = 'PENDING';
            } else {
                $status = 'FAILED';
                $message = __('general.try-again-later');
            }
        }
        return [
            'status' => $status,
            'message' => $message,
            'order' => $order,
            'paymentId' => $paymentId
        ];
    }
}
