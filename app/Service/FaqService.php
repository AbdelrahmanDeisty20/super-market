<?php

namespace App\Service;

use App\Models\Faq;

class FaqService
{
    public function getAllFaqs()
    {
        return Faq::all();
    }
}
