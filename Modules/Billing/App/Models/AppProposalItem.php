<?php

namespace Modules\Billing\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppProposalItem extends Model
{
    protected $table = 'app_proposal_items';
    
    protected $fillable = [
        'app_proposal_id', 'item_name', 'description', 'amount',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function proposal(): BelongsTo
    {
        return $this->belongsTo(AppProposal::class, 'app_proposal_id');
    }
}
