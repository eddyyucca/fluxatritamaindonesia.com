<?php

namespace Modules\Web\App\Http\Controllers;

use App\Http\Controllers\Controller;

class WebController extends Controller
{
    public function index()
    {
        return view('web::company-profile');
    }
}
