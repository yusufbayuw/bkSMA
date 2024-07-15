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

    public function kampus_pilihan(): BelongsTo
    {
        return $this->belongsTo(Kampus::class, 'kampus_pilihan_id', 'id');
    }

    public function jurusan_pilihan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_pilihan_id', 'id');
    }

    public function kampus_real(): BelongsTo
    {
        return $this->belongsTo(Kampus::class, 'kampus_real_id', 'id');
    }

    public function jurusan_real(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_real_id', 'id');
    }
}
