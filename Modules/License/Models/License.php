<?php

namespace Modules\License\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class License extends Model
{
    protected $fillable = [
        'name',
        'client_id',
        'billing_cycle',
        'start_date',
        'expiry_date',
        'price',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the client that owns the license.
     */
    public function client()
    {
        return $this->belongsTo('Modules\Billing\App\Models\Client');
    }

    /**
     * Check if the license is expiring within 30 days.
     */
    public function getIsExpiringAttribute()
    {
        if (!$this->expiry_date) {
            return false;
        }
        return $this->expiry_date->diffInDays(Carbon::now()) <= 30 && $this->expiry_date->isFuture();
    }
}
