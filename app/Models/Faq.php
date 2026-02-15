<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasTranslations;

class Faq extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'question_ar', // السؤال باللغة العربية
        'question_en', // السؤال باللغة الإنجليزية
        'answer_ar', // الإجابة باللغة العربية
        'answer_en', // الإجابة باللغة الإنجليزية
    ]; // الحقول القابلة للتعبئة

    /**
     * الحصول على السؤال المترجم
     */
    public function getQuestionAttribute()
    {
        return $this->getTranslatedValue('question');
    }

    /**
     * الحصول على الإجابة المترجمة
     */
    public function getAnswerAttribute()
    {
        return $this->getTranslatedValue('answer');
    }
}
