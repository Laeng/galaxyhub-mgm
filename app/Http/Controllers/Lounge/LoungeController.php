<?php

namespace App\Http\Controllers\Lounge;

use App\Http\Controllers\Controller;

class LoungeController extends Controller
{
    public function index()
    {
        return view('user.lounge.index');
    }
}
