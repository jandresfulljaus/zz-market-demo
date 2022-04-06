<?php

namespace Modules\Products\Controllers;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Products\Models\Product;

class ProductSheet implements FromCollection, WithHeadings
{
    public function __construct()
    {
        //
    }

    public function collection()
    {
        $data =  Product::getdata()->get();

        return $data;
    }

    public function headings(): array
    {
        //
    }
}
