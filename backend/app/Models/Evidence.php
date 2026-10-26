<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidence extends Model
{
    protected $table = 'evidences';

    protected $fillable = [
        'submission_id', 'indicator_id', 'submission_parameter_id', 'nama_asli', 'path',
        'tipe_file', 'mime', 'ukuran', 'tahun_dokumen', 'teks_ocr', 'status_ocr',
        'catatan', 'uploaded_at',
    ];

    protected function casts(): array
    {
        return [
            'ukuran' => 'integer',
            'tahun_dokumen' => 'integer',
            'uploaded_at' => 'datetime',
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

    public function submissionParameter()
    {
        return $this->belongsTo(SubmissionParameter::class);
    }

    public function scopePunyaTeks($query)
    {
        return $query->whereNotNull('teks_ocr');
    }
}
