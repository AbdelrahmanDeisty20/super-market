<?php

namespace App\Observers;

use App\Models\Offer;
use App\Models\User;
use App\Jobs\BroadcastNotificationJob;

class OfferObserver
{
    /**
     * يتم استدعاء هذه الدالة بعد حفظ العرض الجديد في قاعدة البيانات
     */
    public function created(Offer $offer): void
    {
        // بنتحقق لو العرض "نشط" (is_active) عشان نبعت إشعار
        if ($offer->is_active) {
            $this->sendOfferNotifications($offer);
        }
    }

    /**
     * يتم استدعاء هذه الدالة عند تحديث العرض
     */
    public function updated(Offer $offer): void
    {
        // لو العرض مكنش نشط وبقى نشط (تم تفعيله)، نبعت إشعار
        if ($offer->wasChanged('is_active') && $offer->is_active) {
            $this->sendOfferNotifications($offer);
        }
    }

    /**
     * وظيفة مركزية لإرسال الإشعارات (العامة والمستهدفة)
     */
    protected function sendOfferNotifications(Offer $offer)
    {
        $title = \__('messages.New Offer Available');
        $body = \__('messages.Check out our latest offer: ') . $offer->title;

        // 1. إرسال إشعار عام لكل مستخدمي التطبيق (Broadcast)
        BroadcastNotificationJob::dispatch(
            $title,
            $body,
            ['offer_id' => (string)$offer->id],
            'offer_created'
        );

        // 2. إرسال إشعارات مستهدفة للناس اللي حاطين المنتجات دي في السلة أو المفضلة
        $this->notifyInterestedUsers($offer);
    }

    /**
     * البحث عن المستخدمين المهتمين وإرسال تنبيهات مخصصة لهم
     */
    protected function notifyInterestedUsers(Offer $offer)
    {
        // جلب معرفات كل المنتجات اللي داخلة في العرض ده
        $productIds = $offer->products()->pluck('products.id')->toArray();

        if (empty($productIds)) return;

        $fcmService = app(\App\Service\FcmService::class);

        // أ. الناس اللي حاطين المنتجات في "السلة" - دول ليهم الأولوية القصوى
        $cartUsers = User::whereHas('cart.items', function ($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->get();

        foreach ($cartUsers as $user) {
            $fcmService->sendNotification(
                $user,
                \__('messages.An item in your cart has a new offer!'),
                $offer->title,
                ['offer_id' => (string)$offer->id, 'source' => 'cart'],
                'offer_cart_targeted'
            );
        }

        // ب. الناس اللي حاطين المنتجات في "المفضلة" - بس مش موجودين في لستة السلة عشان ميوصلهمش إشعارين
        $cartUserIds = $cartUsers->pluck('id')->toArray();

        $wishlistUsers = User::whereHas('wishlists', function ($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })
            ->whereNotIn('id', $cartUserIds) // استبعاد اللي جالهم إشعار السلة
            ->get();

        foreach ($wishlistUsers as $user) {
            $fcmService->sendNotification(
                $user,
                \__('messages.An item in your wishlist has a new offer!'),
                $offer->title,
                ['offer_id' => (string)$offer->id, 'source' => 'wishlist'],
                'offer_wishlist_targeted'
            );
        }
    }
}
