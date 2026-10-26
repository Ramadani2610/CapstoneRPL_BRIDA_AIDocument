<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionParameter extends Model
{
    protected $fillable = [
        'submission_id', 'indicator_id', 'tier_id', 'bintang_diklaim', 'catatan',
    ];

    protected function casts(): array
    {
        return ['bintang_diklaim' => 'integer'];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function indicator()
    {
        return $this->belongsTo(Indicator::class);
    }

    public function tier()
    {
        return $this->belongsTo(IndicatorTier::class, 'tier_id');
    }

    public function evidences()
    {
        return $this->hasMany(Evidence::class);
    }
}
