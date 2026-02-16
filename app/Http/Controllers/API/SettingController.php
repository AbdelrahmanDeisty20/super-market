<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    use ApiResponse;

    /**
     * Get all site settings as an associative array.
     */
    public function index(): JsonResponse
    {
        $keys = [
            'site_name',
            'site_logo',
            'contact_email',
            'contact_phone',
            'address',
            'facebook_link',
            'instagram_link',
            'whatsapp_number',
            'currency',
            'min_delivery_fee',
            'home_hero_image',
        ];

        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = Setting::getValue($key);
        }

        return $this->success($settings, __('messages.Settings fetched successfully'));
    }

    /**
     * Get a specific setting.
     */
    public function show($key): JsonResponse
    {
        $value = Setting::getValue($key);

        if ($value === null) {
            return $this->error(__('messages.Setting not found'), 404);
        }

        return $this->success([
            $key => $value
        ]);
    }
}
