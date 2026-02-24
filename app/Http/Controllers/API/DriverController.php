<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Events\DriverLocationUpdated;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DriverController extends Controller
{
    use ApiResponse;

    /**
     * تحديث موقع المندوب وبثه للعميل لحظياً
     */
    public function updateLocation(Request $request, $orderId): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        $order = Order::findOrFail($orderId);

        // تحديث آخر موقع في قاعدة البيانات
        $order->update([
            'last_lat' => $request->lat,
            'last_long' => $request->long,
        ]);

        // بث الموقع الجديد عبر الـ WebSocket
        \event(new DriverLocationUpdated($orderId, $request->lat, $request->long));

        return $this->success([], __('messages.Driver location updated successfully'));
    }
}
