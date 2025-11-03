<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use Hekmatinasser\Verta\Verta;

class UserExport implements FromCollection, ShouldAutoSize, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'نام',
            'نام خانوادگی',
            'کدملی',
            'شماره موبایل',
            'تاریخ تولد',
            'آدرس ایمیل',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    public function collection()
    {
        $users = User::select('name','family','nationalCode','mobile','birthday','email')->get();
        foreach ($users as $key => $user) {
        	$user->birthday = Verta($user->birthday)->format('Y/m/d');
        }

        return $users;
    }
}
