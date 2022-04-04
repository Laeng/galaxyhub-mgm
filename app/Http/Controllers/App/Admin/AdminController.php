<?php

namespace App\Http\Controllers\App\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('app.admin.index');
    }


}
