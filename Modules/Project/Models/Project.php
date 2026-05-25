<?php

namespace Modules\Project\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'client_id',
        'deadline',
        'status',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo('Modules\Billing\App\Models\Client');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->orderBy('order_position');
    }
}
