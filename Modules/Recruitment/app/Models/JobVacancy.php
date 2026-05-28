<?php

namespace Modules\Recruitment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Recruitment\Database\Factories\JobVacancyFactory;

class JobVacancy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'department',
        'description',
        'requirements',
        'location',
        'salary_range',
        'status',
        'closing_date',
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
