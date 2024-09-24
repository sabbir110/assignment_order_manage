<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderRepositoryInterface
{
    public function placeOrder(array $orderItems)
    {
        $totalAmount = 0;
        foreach ($orderItems as $item) {
            $product = Product::find($item['product_id']);
            if (!$product || $product->stock < $item['quantity']) {
                throw new \Exception('Product out of stock');
            }

            $totalAmount += $product->price * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'total_amount' => $totalAmount,
        ]);

        foreach ($orderItems as $item) {
            $product = Product::find($item['product_id']);
            $product->stock -= $item['quantity'];
            $product->save();

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        return $order;

    }

    public function getOrderHistory($id)
    {
        $user = Auth::user();
        if ($id == "") {
            $orders = Order::where('user_id', $user->id)->get();
            return $orders;
        }

        $order_details = Order::where('user_id', $user->id)->where("id", $id)->with(['items.product:id,name'])->first();
        return $order_details;
    }
}
