<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class MyUserImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) 
        {
            if ($key === 0) {
                //
            } else {
                //if (User::find($row[0])) {}
                User::updateOrCreate(
                    ['id' => $row[0],],[
                    'angkatan_lulus_id' => $row[1],
                    'name' => $row[2],
                    'kelas' => $row[3],
                    'email' => $row[4],
                    'username' => $row[5],
                    'nilai' => $row[6],
                ]);
            }           
        }
    }
    
}
