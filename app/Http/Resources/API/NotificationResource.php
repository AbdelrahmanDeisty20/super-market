<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title, // عنوان الإشعار
            'body' => $this->body,   // نص الإشعار
            'type' => $this->type,   // نوع الإشعار (order_created)
            'data' => $this->data,   // أي بيانات إضافية (مثل order_id)
            'is_read' => $this->read_at !== null, // هل تم قراءة الإشعار أم لا
            'created_at' => $this->created_at->diffForHumans(), // الوقت بشكل نسبي (منذ 5 دقائق)
            'timestamp' => $this->created_at->format('Y-m-d H:i:s'), // الوقت الفعلي
        ];
    }
}
