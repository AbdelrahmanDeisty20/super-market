<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            ExportAction::make()
                ->label(__('Admin.actions.export'))
                ->exports([
                    ExcelExport::make()
                        ->withColumns([
                            Column::make('id')->heading('ID'),
                            Column::make('name_ar')->heading(__('Admin.fields.name_ar')),
                            Column::make('name_en')->heading(__('Admin.fields.name_en')),
                            Column::make('price')->heading(__('Admin.fields.price')),
                            Column::make('discount_price')->heading(__('Admin.fields.discount_price')),
                            Column::make('stock')->heading(__('Admin.fields.stock')),
                            Column::make('category.name_ar')->heading(__('Admin.fields.category')),
                            Column::make('brand.name_ar')->heading(__('Admin.fields.brand')),
                            Column::make('unit.name_ar')->heading(__('Admin.fields.unit')),
                            Column::make('min_quantity')->heading(__('Admin.fields.min_quantity')),
                            Column::make('step_quantity')->heading(__('Admin.fields.step_quantity')),
                            Column::make('is_featured')->heading(__('Admin.fields.is_featured')),
                        ]),
                ]),
            \Filament\Actions\Action::make('import')
                ->label(__('Admin.actions.import'))
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label(__('Admin.fields.file') ?? 'الملف')
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                        ])
                        ->required(),
                ])
                ->action(function (array $data) {
                    $file = \Illuminate\Support\Facades\Storage::disk('local')->path($data['file']);

                    try {
                        $rows = \Spatie\SimpleExcel\SimpleExcelReader::create($file)->getRows();

                        $successCount = 0;
                        $rows->each(function (array $row) use (&$successCount) {
                            // Mapping headers (Arabic to English keys)
                            $mappedData = [
                                'id' => $row['ID'] ?? $row['id'] ?? $row['رقم'] ?? null,
                                'name_ar' => $row['الاسم (بالعربية)'] ?? $row['الاسم عربي'] ?? $row['الاسم'] ?? null,
                                'name_en' => $row['الاسم (بالانجليزية)'] ?? $row['الاسم انجليزي'] ?? null,
                                'description_ar' => $row['الوصف (بالعربية)'] ?? $row['وصف المنتج'] ?? $row['الوصف'] ?? $row['تفاصيل'] ?? 'لا يوجد وصف',
                                'description_en' => $row['الوصف (بالانجليزية)'] ?? $row['الوصف en'] ?? null,
                                'price' => $row['السعر'] ?? $row['Price'] ?? 0,
                                'discount_price' => $row['سعر الخصم'] ?? $row['الخصم'] ?? null,
                                'stock' => $row['المخزون'] ?? $row['الكمية'] ?? 0,
                                'min_quantity' => $row['أقل كمية'] ?? $row['الحد الأدنى'] ?? 1,
                                'step_quantity' => $row['مقدار الزيادة'] ?? 1,
                                'is_featured' => (bool) ($row['مميز'] ?? $row['Featured'] ?? false),
                            ];

                            // Relationship Resolution
                            if ($categoryName = ($row['القسم'] ?? $row['Category'] ?? null)) {
                                $mappedData['category_id'] = \App\Models\Category::where('name_ar', $categoryName)->orWhere('name_en', $categoryName)->first()?->id;
                            }
                            if ($brandName = ($row['الماركة'] ?? $row['Brand'] ?? null)) {
                                $mappedData['brand_id'] = \App\Models\Brand::where('name_ar', $brandName)->orWhere('name_en', $brandName)->first()?->id;
                            }
                            if ($unitName = ($row['الوحدة'] ?? $row['Unit'] ?? null)) {
                                $mappedData['unit_id'] = \App\Models\Unit::where('name_ar', $unitName)->orWhere('name_en', $unitName)->first()?->id;
                            }

                            if ($mappedData['name_ar']) {
                                \App\Models\Product::updateOrCreate(
                                    ['id' => $mappedData['id']],
                                    \Illuminate\Support\Arr::except($mappedData, ['id'])
                                );
                                $successCount++;
                            }
                        });

                        \Filament\Notifications\Notification::make()
                            ->title('تم الاستيراد بنجاح')
                            ->body("تم استيراد $successCount منتج بنجاح.")
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        \Filament\Notifications\Notification::make()
                            ->title('خطأ في الاستيراد')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
