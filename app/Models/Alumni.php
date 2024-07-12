<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Model
{
    use HasFactory;

    public function angkatan_lulus(): BelongsTo
    {
        return $this->belongsTo(AngkatanLulus::class, 'angkatan_lulus_id', 'id');
    }

    public function kampuses(): BelongsTo
    {
        return $this->belongsTo(Kampus::class, 'kampus_id', 'id');
    }

    public function jurusans(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'id');
    }
}
