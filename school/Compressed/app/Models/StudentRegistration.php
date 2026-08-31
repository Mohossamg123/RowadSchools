<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'parent_name',
        'phone',
        'email',
        'gender',
        'educational_stage_id',
        'grade_id',
        'status',
        'email_notification_sent',
    'email_notification_sent_at',
    ];
    

protected $casts = [
    'email_notification_sent' => 'boolean',
    'email_notification_sent_at' => 'datetime',
];

    public function educationalStage(): BelongsTo
    {
        return $this->belongsTo(EducationalStage::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}
