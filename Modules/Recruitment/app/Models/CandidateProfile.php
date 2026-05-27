<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Recruitment\Database\Factories\CandidateProfileFactory;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'gender',
        'date_of_birth',
        'education_level',
        'major',
        'university',
        'experience_years',
        'skills',
        'cv_path',
        'status',
        'applied_position',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
