<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller {

  public function index() {
    return Order::all();
  }

  public function getOrders(Request $request) {
    $user_id = $request->user_id;
    $orders = Order::where('user_id', $user_id)->get();

    return response()->json(['status' => 'success', 'orders' => $orders]);
  }

  public function create(Request $request) {

    $order = new Order;
    $data = $request->json()->all();

    $order->user_id = $data['user_id'];
    $order->email = $data['email'];
    $order->address = $data['address'];
    $order->discount = $data['discount'];
    $order->products = $data['products'];
    $order->name = $data['name'];
    $order->total_price = $data['total_price'];
    $order->phone_number = $data['phone_number'];
    $order->delivery_price = $data['delivery_price'];
    $order->payment_status = $data['payment_status'];
    $order->subtotal_price = $data['subtotal_price'];

    $order->save();

    return response()->json(['status' => 'success', 'data' => $data]);
  }
}
