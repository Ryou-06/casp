<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable = [
        'teacher_id',
        'title',
        'description',
        'subject',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Assignment belongs to a teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // Assignment has many submissions
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    // Check if assignment is past due
    public function isPastDue(): bool
    {
        return now()->greaterThan($this->due_date);
    }
}