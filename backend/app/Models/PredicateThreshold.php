<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PredicateThreshold extends Model
{
    protected $fillable = ['tahun', 'nama_predikat', 'skor_min', 'skor_max'];

    protected function casts(): array
    {
        return ['tahun' => 'integer', 'skor_min' => 'decimal:2', 'skor_max' => 'decimal:2'];
    }
}
