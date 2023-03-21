<?php

namespace App\Http\Controllers;

use App\Models\OrderTransaction;
use App\Models\PaymentMethod;
use App\Services\CartService;
use Illuminate\Http\Request;

class NotifyController extends Controller
{

    public function monetBilCallback(Request $request) {
        $status = $request->get('status');
        if ($status == 1) {
            $transaction = $request->get('transaction');
            $transaction_id = $transaction['transaction_UUID'];
            if (!OrderTransaction::whereExternalNumber($transaction_id)->first()) {
                (new CartService())->savePaidOrder($transaction_id, $transaction['user'],
                    PaymentMethod::whereCode('MONETBIL')->first(), $transaction);
                return response(['success' => true]);
            }
        }
        return response(['success' => false]);
    }

    public function mobileMoney(Request $request) {
        $externalId = $request->get("externalId");
        $financialId = $request->get('financialTransactionId');
        if (!OrderTransaction::whereExternalNumber($financialId)->exists()) {
            (new CartService())->savePaidOrder($financialId, $externalId,
                PaymentMethod::whereCode('MOMO')->first(), $request->all());
            return response(['success' => true]);
        }
        return response(['success' => false]);
    }
}
