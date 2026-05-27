<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Recruitment\Database\Factories\JobApplicationFactory;

class JobApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'job_vacancy_id',
        'cv_path',
        'expected_salary',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }
}
