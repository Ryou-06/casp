<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Teacher role check
    public function isTeacher(): bool
    {
        return $this->role === 'teacher';
    }

    // Student role check
    public function isStudent(): bool
    {
        return $this->role === 'student';
    }
    
    // Alternative: Check if user has a specific role
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
    
    // Get all assignments created by this teacher
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }
    
    // Get all submissions made by this student
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }
}