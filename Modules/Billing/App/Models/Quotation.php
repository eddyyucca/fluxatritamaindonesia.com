<?php

namespace Modules\Billing\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Quotation extends Model
{
    protected $fillable = [
        'quotation_number', 'client_id', 'created_by', 'title', 'description',
        'terms_and_conditions', 'status', 'subtotal', 'pt_profit_percent',
        'pt_profit_amount', 'user_amount', 'total', 'notes', 'valid_until',
        'approved_by', 'approved_at', 'qr_token',
    ];

    protected function casts(): array
    {
        return [
            'valid_until'  => 'date',
            'approved_at'  => 'datetime',
            'subtotal'     => 'decimal:2',
            'pt_profit_amount' => 'decimal:2',
            'user_amount'  => 'decimal:2',
            'total'        => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Quotation $q) {
            if (empty($q->qr_token)) {
                $q->qr_token = Str::uuid();
            }
            if (empty($q->quotation_number)) {
                $q->quotation_number = self::generateNumber();
            }
        });
    }

    public static function generateNumber(): string
    {
        $year  = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'Q/FTI/' . $year . '/' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotals(): void
    {
        $this->subtotal         = $this->items->sum('amount');
        $this->total            = $this->subtotal;
        $this->pt_profit_amount = round($this->subtotal * ($this->pt_profit_percent / 100), 2);
        $this->user_amount      = round($this->subtotal - $this->pt_profit_amount, 2);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'    => 'Draft',
            'sent'     => 'Menunggu Persetujuan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft'    => 'slate',
            'sent'     => 'amber',
            'approved' => 'emerald',
            'rejected' => 'red',
            default    => 'slate',
        };
    }
}
