<?php

namespace App\Filament\Imports;

use App\Models\Product;
use Filament\Actions\Imports\Models\Import;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Illuminate\Support\Number;

class ProductImporter extends Importer
{
    protected static ?string $model = Product::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('id')
                ->label('ID')
                ->guess(['ID', 'id', 'رقم التعريف', 'المسلسل']),
            ImportColumn::make('name_ar')
                ->label(__('Admin.fields.name_ar'))
                ->guess(['الاسم (بالعربية)', 'الاسم عربي', 'اسم المنتج', 'الاسم'])
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('name_en')
                ->label(__('Admin.fields.name_en'))
                ->guess(['الاسم (بالانجليزية)', 'الاسم انجليزي', 'Product Name', 'Name']),
            ImportColumn::make('description_ar')
                ->label(__('Admin.fields.description_ar'))
                ->guess(['الوصف (بالعربية)', 'وصف المنتج', 'الوصف', 'تفاصيل'])
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('description_en')
                ->label(__('Admin.fields.description_en'))
                ->guess(['الوصف (بالانجليزية)', 'Description']),
            ImportColumn::make('price')
                ->label(__('Admin.fields.price'))
                ->guess(['السعر', 'سعر البيع', 'Price'])
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('discount_price')
                ->label(__('Admin.fields.discount_price'))
                ->guess(['سعر الخصم', 'الخصم', 'Discount'])
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('stock')
                ->label(__('Admin.fields.stock'))
                ->guess(['المخزون', 'الكمية', 'Stock', 'Quantity'])
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('category')
                ->label(__('Admin.fields.category'))
                ->guess(['القسم', 'التصنيف', 'Category'])
                ->requiredMapping()
                ->relationship(name: 'category', resolveUsing: 'name_ar'),
            ImportColumn::make('brand')
                ->label(__('Admin.fields.brand'))
                ->guess(['الماركة', 'العلامة التجارية', 'Brand'])
                ->requiredMapping()
                ->relationship(name: 'brand', resolveUsing: 'name_ar'),
            ImportColumn::make('unit')
                ->label(__('Admin.fields.unit'))
                ->guess(['الوحدة', 'وحدة القياس', 'Unit'])
                ->relationship(name: 'unit', resolveUsing: 'name_ar'),
            ImportColumn::make('min_quantity')
                ->label(__('Admin.fields.min_quantity'))
                ->guess(['أقل كمية', 'الحد الأدنى', 'Min Quantity'])
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('step_quantity')
                ->label(__('Admin.fields.step_quantity'))
                ->guess(['مقدار الزيادة', 'Quantity Step'])
                ->numeric()
                ->rules(['nullable', 'integer']),
            ImportColumn::make('is_featured')
                ->label(__('Admin.fields.is_featured'))
                ->guess(['مميز', 'Featured', 'منتج مميز'])
                ->boolean()
                ->rules(['nullable', 'boolean']),
        ];
    }

    public function resolveRecord(): Product
    {
        return Product::firstOrNew([
            'id' => $this->data['id'] ?? null,
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your product import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
