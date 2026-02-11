<?php

namespace App\Traits;

trait HasTranslations
{
    /**
     * Get the translated value for a given field.
     * Following the pattern: ($locale === 'ar' ? $field_ar : $field_en) ?: $field_ar
     *
     * @param string $field
     * @return mixed
     */
    protected function getTranslatedValue(string $field)
    {
        $locale = app()->getLocale();
        $arField = "{$field}_ar";
        $enField = "{$field}_en";

        return ($locale === 'ar' ? $this->{$arField} : $this->{$enField}) ?: $this->{$arField};
    }
}
