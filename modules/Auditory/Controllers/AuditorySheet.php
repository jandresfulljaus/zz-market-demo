<?php

namespace Modules\Auditory\Controllers;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Modules\Auditory\Models\Auditory;

class AuditorySheet implements FromCollection, WithHeadings
{
    public function __construct()
    {
        //
    }

    public function collection()
    {
        $data =  Auditory::getdata()->get();

        return $data;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Estado'
        ];
    }
}
