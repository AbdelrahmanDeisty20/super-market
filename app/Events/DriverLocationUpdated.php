<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $lat;
    public $long;

    /**
     * Create a new event instance.
     */
    public function __construct($orderId, $lat, $long)
    {
        $this->orderId = $orderId;
        $this->lat = $lat;
        $this->long = $long;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // بنبعت إحداثيات المندوب على نفس القناة الخاصة بالأوردر
        return [
            new PrivateChannel('orders.' . $this->orderId),
        ];
    }

    /**
     * البيانات اللي هتتبع للعميل لحظياً
     */
    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->orderId,
            'lat' => $this->lat,
            'long' => $this->long,
        ];
    }
}
