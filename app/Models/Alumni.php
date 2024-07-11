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
}
