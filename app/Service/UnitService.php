<?php

namespace App\Service;

use App\Models\Unit;

class UnitService
{
    /**
     * Get all measurement units.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUnits()
    {
        return Unit::latest()->get();
    }
}
