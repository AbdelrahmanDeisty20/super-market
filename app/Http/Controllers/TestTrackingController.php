<?php

namespace App\Http\Controllers;

use App\Events\DriverLocationUpdated;
use App\Models\Order;
use Illuminate\Http\Request;

class TestTrackingController extends Controller
{
    /**
     * عرض صفحة المعمل (Testing Lab)
     */
    public function index(Request $request)
    {
        $orderId = $request->query('order_id', 6);
        $order = Order::with('user')->find($orderId);

        if (!$order) {
            return "Order #{$orderId} not found in database.";
        }

        // تسجيل الدخول تلقائياً بصاحب الأوردر عشان نقدر نفتح الـ Private Channel بسهولة (للتجربة فقط)
        if (app()->environment('local')) {
            auth()->loginUsingId($order->user_id);
        }

        return view('test.tracking-lab', compact('order'));
    }

    /**
     * محاكاة حركة المندوب (تلقي الموقع وبثه)
     */
    public function updateLocation(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        $order = Order::findOrFail($request->order_id);

        // 1. تحديث الداتابيز فعلياً
        $order->update([
            'last_lat' => $request->lat,
            'last_long' => $request->lng,
        ]);

        // 2. بث الموقع على القناة الخاصة بالأوردر (الإنتاج)
        event(new DriverLocationUpdated($order->id, $request->lat, $request->lng));

        return response()->json(['status' => 'success']);
    }
}
