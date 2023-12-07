<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    use HasFactory;

    public function kampuses(): BelongsTo
    {
        return $this->belongsTo(Kampus::class, 'kampus_id', 'id');
    }

    public function pilihans(): HasMany
    {
        return $this->hasMany(Pilihan::class, 'pilihan_id', 'id');
    }
}
