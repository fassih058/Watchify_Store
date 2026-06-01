<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Watch;
use App\Models\OrderItem;
use Illuminate\Http\Request;


class OrderController extends Controller
{
    public function index()
    {
        $allOrders = Order::all();

        return view('admin.orders.index', compact('allOrders'));
    }

    public function show(Request $req)
    {
        $orderId = $req->id;

        $orderItems = OrderItem::where('order_id', $orderId)->get();

        $totalPrice = 0;

        foreach ($orderItems as $item) {
            $totalPrice += $item->price * $item->quantity;
        }

        return view('admin.orders.show', compact('orderItems', 'totalPrice'));
    }

    public function update(Request $req)
    {
        $id = $req->order_id;

        $order = Order::where('id', $id)->first();

        $newStatus = $req->status;
        $oldStatus = $order->status;

        if ($oldStatus === $newStatus) {
            return redirect()->route('admin.orders.index')
                ->with('success', 'Same Status. No Change!');
        }


        if ($newStatus === 'cancelled') {

            $orderItems = OrderItem::where('order_id', $order->id)->get();

            foreach ($orderItems as $item) {
                $watch = Watch::where('id', $item->watch_id)->first();
                $watch->stock = $watch->stock + $item->quantity;
                $watch->save();
            }
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully!');
    }
}
