<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VerificatorDecision extends Model
{
    protected $table = 'verificator_decisions';

    protected $fillable = [
        'submission_id', 'indicator_id', 'ai_assessment_id', 'bobot_saat_itu',
        'bintang_final', 'skor', 'sesuai_rekomendasi_ai', 'catatan',
        'diputuskan_oleh', 'diputuskan_pada',
    ];

    protected function casts(): array
    {
        return [
            'bobot_saat_itu' => 'integer',
            'bintang_final' => 'integer',
            'skor' => 'decimal:2',
            'sesuai_rekomendasi_ai' => 'boolean',
            'diputuskan_pada' => 'datetime',
        ];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function aiAssessment()
    {
        return $this->belongsTo(AiAssessment::class);
    }

    public function pemutus()
    {
        return $this->belongsTo(User::class, 'diputuskan_oleh');
    }
}
