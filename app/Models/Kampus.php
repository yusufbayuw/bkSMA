<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kampus extends Model
{
    use HasFactory;

    public function pilihans(): HasMany
    {
        return $this->hasMany(Pilihan::class, 'pilihan_id', 'id');
    }

    public function jurusans(): HasMany
    {
        return $this->hasMany(Jurusan::class, 'jurusan_id', 'id');
    }
}
