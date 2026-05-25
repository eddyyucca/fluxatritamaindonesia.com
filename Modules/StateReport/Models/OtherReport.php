<?php

namespace Modules\StateReport\Models;

use Illuminate\Database\Eloquent\Model;

class OtherReport extends Model
{
    protected $table = 'other_reports';
    protected $fillable = ['title', 'institution', 'report_date', 'status', 'file_path', 'notes'];
}
