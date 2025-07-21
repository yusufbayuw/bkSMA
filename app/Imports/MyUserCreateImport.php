<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;

class MyUserCreateImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $users = [];
        foreach ($collection as $key => $row) {
            if ($key === 0) {
                continue;
            }
            $users[] = [
                'email' => $row[1],
                'username' => $row[2],
                'angkatan_lulus_id' => $row[9],
                'password' => Hash::make($row[3]),
                'is_can_choose' => $row[4],
                'is_choosed' => $row[5],
                'program' => $row[8],
                'name' => $row[0],
                'kelas' => $row[7],
                'nilai' => $row[6],
            ];
        }
        if (!empty($users)) {
            User::upsert(
                $users,
                ['email', 'username'],
                ['angkatan_lulus_id', 'password', 'is_can_choose', 'is_choosed', 'program', 'name', 'kelas', 'nilai']
            );
        }
    }
}
