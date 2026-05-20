<?php

namespace Modules\Billing\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuotationItem extends Model
{
    protected $fillable = ['quotation_id', 'description', 'quantity', 'unit_price', 'amount'];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'amount'     => 'decimal:2',
        ];
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }
}
