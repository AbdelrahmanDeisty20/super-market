<?php

namespace App\Service;

use App\Models\Banner;

class BannerService
{
    public function getActiveBanners()
    {
        return Banner::where('is_active', true)->get();
    }
}
