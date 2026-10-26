<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionStatusHistory extends Model
{
    protected $fillable = [
        'submission_id', 'status_lama', 'status_baru', 'oleh_user_id', 'catatan', 'dibuat_pada',
    ];

    protected function casts(): array
    {
        return ['dibuat_pada' => 'datetime'];
    }

    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    public function oleh()
    {
        return $this->belongsTo(User::class, 'oleh_user_id');
    }
}
