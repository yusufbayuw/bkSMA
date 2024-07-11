<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AngkatanLulus extends Model
{
    use HasFactory;

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'angkatan_lulus_id', 'id');
    }

    public function alumni(): HasMany
    {
        return $this->hasMany(Alumni::class, 'angkatan_lulus_id', 'id');
    }
}
