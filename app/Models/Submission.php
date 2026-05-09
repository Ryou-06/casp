<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'file_name',
        'file_size',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'file_size' => 'integer',
    ];

    // Submission belongs to an assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    // Submission belongs to a student
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    // Format file size for display
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) return 'N/A';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        $size = $this->file_size;
        
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        
        return round($size, 2) . ' ' . $units[$i];
    }

    // In App\Models\Submission.php

// Add this accessor after the getFormattedFileSizeAttribute method
public function getIsLateAttribute()
{
    if (!$this->assignment || !$this->assignment->due_date) {
        return false;
    }
    
    return $this->submitted_at->gt($this->assignment->due_date);
}

// Add this to get late status text
public function getLateStatusAttribute()
{
    return $this->is_late ? 'Late' : 'On Time';
}

// Add this for styling
public function getLateStatusClassAttribute()
{
    return $this->is_late ? 'text-red-600 bg-red-50' : 'text-green-600 bg-green-50';
}
}