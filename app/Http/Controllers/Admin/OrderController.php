<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Exports\OrdersExport;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class OrderController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index() {
        $orders = Order::when(\request()->keyword != null, function ($query) {
                $query->search(\request()->keyword);
            })
            ->when(\request()->status != null, function ($query) {
                $query->whereOrderStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'created_at', \request()->orderBy ?? 'desc')
            ->paginate(\request()->limitBy ?? 10);
        return view('backend.orders.index', compact('orders'));
    }

    /**
     * @return BinaryFileResponse
     */
    public function export(): BinaryFileResponse
    {
        $orders = Order::when(\request()->keyword != null, function ($query) {
            $query->search(\request()->keyword);
        })
            ->when(\request()->status != null, function ($query) {
                $query->whereOrderStatus(\request()->status);
            })
            ->orderBy(\request()->sortBy ?? 'created_at', \request()->orderBy ?? 'desc');
        if (\request()->limitBy) {
            $orders = $orders->limit(\request()->limitBy);
        }
        $orders = $orders->get();
        return Excel::download(new OrdersExport($orders), 'orders.xlsx');

    }

    public function show(Order $order): View
    {
        $orderStatusArray = [
            '0' => 'Unpaid',
            '1' => 'Paid',
            '2' => 'Under process',
            '3' => 'Finished',
            '4' => 'Rejected',
            '5' => 'Canceled',
            '6' => 'Refund requested',
            '7' => 'Returned order',
            '8' => 'Refunded',
        ];

        $key = array_search($order->order_status, array_keys($orderStatusArray));
        foreach ($orderStatusArray as $k => $v) {
            if ($k <= $key) {
                unset($orderStatusArray[$k]);
            }
        }

        return view('backend.orders.show', compact('order', 'orderStatusArray'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {

        $order->update(['order_status'=> $request->order_status]);

        if ($order->transaction) {
            $order->transaction()->update([
                'transaction_status' => $request->order_status,
            ]);
        } else {
            $order->transactions()->create([
                'transaction_status' => $request->order_status,
                'transaction_number' => null,
                'payment_result' => null,
            ]);
        }

        return back()->with([
            'message' => 'updated successfully',
            'alert-type' => 'success',
        ]);
    }

    /**
     * @param Order $order
     * @return RedirectResponse
     */
    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with([
            'message' => 'Deleted successfully',
            'alert-type' => 'success'
        ]);
    }
}
