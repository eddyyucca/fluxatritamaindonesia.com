<?php

namespace Modules\StateReport\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialReport extends Model
{
    protected $table = 'financial_reports';
    protected $fillable = ['year', 'period', 'status', 'file_path', 'notes'];
}
