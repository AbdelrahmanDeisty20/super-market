<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// قناة خاصة لتتبع الأوردر لحظة بلحظة، بيتأكد إن صاحب الأوردر هو بس اللي يقدر يسمع التحديثات
Broadcast::channel('orders.{orderId}', function ($user, $orderId) {
    $order = \App\Models\Order::find($orderId);
    return $order && $user->id === $order->user_id;
});
