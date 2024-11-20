<?php

namespace App\Exports\Letters;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OutgoingLettersExport implements FromCollection, WithHeadings
{
    protected $letters;

    public function __construct($letters)
    {
        $this->letters = $letters;
    }

    public function collection()
    {
        return $this->letters->map(function ($letter) {
            return [
                'No' => $letter->id,
                'Tipe Surat' => ucwords(str_replace('_', ' ', $letter->letter_type)),
                'Nomor Surat' => $letter->letter_number,
                'Tanggal Surat' => $letter->letter_date,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tipe Surat',
            'Nomor Surat',
            'Tanggal Surat',
        ];
    }
}
