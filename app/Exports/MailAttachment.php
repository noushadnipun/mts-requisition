<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MailAttachment implements FromCollection, WithHeadings
{
    use Exportable;
    private $arr;

    public function __construct($arr)
    {
        $this->arr = $arr;
    }

    public function collection()
    {
        return collect($this->arr);
    }

    public function headings(): array
    {
        return [
            'Name',
            'Surname',
            'Email',
            'Twitter',
        ];
    }

}


?>
