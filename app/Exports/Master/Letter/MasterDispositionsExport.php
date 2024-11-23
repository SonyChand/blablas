<?php

namespace App\Exports\Master\Letter;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterDispositionsExport implements FromCollection, WithHeadings
{
    protected $master;

    public function __construct($master)
    {
        $this->master = $master;
    }

    public function collection()
    {
        return $this->master->map(function ($master) {
            return [
                'No' => $master->uuid,
                'Posisi' => $master->employee->position,
                'Alias' => $master->alias,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Posisi',
            'Alias',
        ];
    }
}
