<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_DIAJUKAN = 'diajukan';

    public const STATUS_DIPROSES = 'diproses';

    public const STATUS_DIREVISI = 'direvisi';

    public const STATUS_DITERIMA = 'diterima';

    public const STATUS_DITOLAK = 'ditolak';

    protected $fillable = [
        'user_id', 'judul', 'deskripsi', 'opd', 'kategori', 'tahun', 'status',
        'verifikator_id', 'submitted_at', 'decided_at', 'total_skor', 'predikat',
        'catatan_revisi',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'decided_at' => 'datetime',
            'total_skor' => 'decimal:2',
            'tahun' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikator_id');
    }

    public function parameters()
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

    public function statusHistories()
    {
        return $this->hasMany(SubmissionStatusHistory::class);
    }

    public function bolehDiubah(): bool
    {
        return in_array($this->status, [self::STATUS_DRAFT, self::STATUS_DIREVISI], true);
    }

    public function scopeAntrian($query)
    {
        return $query->whereIn('status', [self::STATUS_DIAJUKAN, self::STATUS_DIPROSES]);
    }
}
