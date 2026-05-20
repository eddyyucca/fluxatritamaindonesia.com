<?php

namespace Modules\Billing\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number', 'quotation_id', 'client_id', 'created_by', 'title',
        'description', 'terms_and_conditions', 'status', 'subtotal',
        'pt_profit_percent', 'pt_profit_amount', 'user_amount', 'total',
        'invoice_date', 'due_date', 'notes', 'approved_by', 'approved_at', 'qr_token',
    ];

    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
            'due_date'     => 'date',
            'approved_at'  => 'datetime',
            'subtotal'     => 'decimal:2',
            'pt_profit_amount' => 'decimal:2',
            'user_amount'  => 'decimal:2',
            'total'        => 'decimal:2',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Invoice $inv) {
            if (empty($inv->qr_token)) {
                $inv->qr_token = Str::uuid();
            }
            if (empty($inv->invoice_number)) {
                $inv->invoice_number = self::generateNumber();
            }
        });
    }

    public static function generateNumber(): string
    {
        $year  = now()->year;
        $count = self::whereYear('created_at', $year)->count() + 1;
        return 'INV/FTI/' . $year . '/' . str_pad($count, 4, '0', STR_PAD_LEFT);
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

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
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
        return $this->hasMany(InvoiceItem::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'            => 'Draft',
            'pending_approval' => 'Menunggu Persetujuan Final Director',
            'approved'         => 'Diterbitkan (Aktif)',
            'rejected'         => 'Ditolak',
            'paid'             => 'Lunas',
            default            => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft'            => 'slate',
            'pending_approval' => 'amber',
            'approved'         => 'blue',
            'rejected'         => 'red',
            'paid'             => 'emerald',
            default            => 'slate',
        };
    }
}
