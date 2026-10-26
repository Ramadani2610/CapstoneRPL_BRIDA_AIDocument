<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicatorTier extends Model
{
    protected $fillable = [
        'indicator_id', 'tahun', 'bintang', 'label', 'deskripsi_bukti', 'konfigurasi',
    ];

    protected function casts(): array
    {
        return [
            'bintang' => 'integer',
            'tahun' => 'integer',
            'konfigurasi' => 'array',
        ];
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function submissionParams()
    {
        return $this->hasMany(SubmissionParameter::class, 'tier_id');
    }
}
