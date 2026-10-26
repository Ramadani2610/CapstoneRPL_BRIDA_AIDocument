<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $fillable = [
        'kode', 'nama', 'deskripsi', 'bobot', 'wajib',
        'tipe_bukti', 'rentang_tahun', 'dalam_scope', 'urutan',
    ];

    protected function casts(): array
    {
        return [
            'bobot' => 'integer',
            'wajib' => 'boolean',
            'dalam_scope' => 'boolean',
        ];
    }

    /** Route binding uses `kode` (21..44) instead of the id. */
    public function getRouteKeyName(): string
    {
        return 'kode';
    }

    public function tiers()
    {
        return $this->hasMany(IndicatorTier::class);
    }

    public function submissionParams()
    {
        return $this->hasMany(SubmissionParameter::class);
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class);
    }

    public function assessments()
    {
        return $this->hasMany(AiAssessment::class);
    }

    public function decisions()
    {
        return $this->hasMany(VerificatorDecision::class);
    }

    public function scopeDalamScope($query)
    {
        return $query->where('dalam_scope', true);
    }
}
