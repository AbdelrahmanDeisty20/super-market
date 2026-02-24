<?php

namespace App\Observers;

use App\Filament\Resources\Products\ProductResource;
use App\Models\Product;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class ProductObserver
{
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        // التحقق إذا كان عمود المخزون قد تغير
        // بنستخدم wasChanged عشان التأكد إن التغيير حصل فعلاً واتحفظ في الداتابيز
        if ($product->wasChanged('stock')) {
            $this->checkStockLevelForProduct($product);
        }
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this->checkStockLevelForProduct($product);
    }

    /**
     * Check stock level and send notification if low.
     */
    public function checkStockLevelForProduct(Product $product): void
    {
        if ($product->stock < 10) {
            // جلب المسؤولين (super_admin)
            $admins = User::role('super_admin')->get();

            if ($admins->isEmpty()) {
                // إذا لم يوجد، نرسل لأول مستخدم في قاعدة البيانات (كخطة بديلة)
                $admins = User::limit(1)->get();
            }

            foreach ($admins as $admin) {
                // 1. إرسال إشعار للوحة التحكم (Filament)
                Notification::make()
                    ->title(__('messages.Low Stock Alert'))
                    ->warning()
                    ->body(__('messages.Product') . ' "' . $product->name . '" ' . __('messages.is low on stock') . ': ' . $product->stock)
                    ->actions([
                        Action::make('view')
                            ->url(ProductResource::getUrl('edit', ['record' => $product])),
                    ])
                    ->sendToDatabase($admin);
            }
        }
    }
}
