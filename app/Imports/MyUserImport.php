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
                    'name' => $row[1],
                    'email' => $row[2],
                    'username' => $row[3],
                    'nilai' => $row[4],
                ]);
            }           
        }
    }
    
}
