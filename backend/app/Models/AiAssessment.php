<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiAssessment extends Model
{
    protected $table = 'ai_assessments';

    protected $fillable = [
        'submission_id', 'indicator_id', 'mesin', 'model', 'versi_prompt',
        'usulan_bintang', 'keyakinan', 'ringkasan', 'keluaran_mentah', 'dibuat_pada',
    ];

    protected function casts(): array
    {
        return [
            'usulan_bintang' => 'integer',
            'keyakinan' => 'decimal:3',
            'keluaran_mentah' => 'array',
            'dibuat_pada' => 'datetime',
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
}
