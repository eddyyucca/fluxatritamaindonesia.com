<?php

namespace Modules\StateReport\Models;

use Illuminate\Database\Eloquent\Model;

class TaxReturn extends Model
{
    protected $table = 'tax_returns';
    protected $fillable = ['tax_type', 'year', 'period', 'status', 'file_path', 'notes'];
}
