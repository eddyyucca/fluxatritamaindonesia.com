<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    protected $fillable = [
        'title', 'category', 'amount', 'expense_date', 
        'has_tax', 'tax_amount', 'receipt_path', 'notes'
    ];
}
