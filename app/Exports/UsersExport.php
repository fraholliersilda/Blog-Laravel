<?php
namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class UsersExport implements FromCollection, WithHeadings, WithTitle
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select('name', 'email', 'role_id')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return ['Name', 'Email', 'Role'];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Users';
    }
}
