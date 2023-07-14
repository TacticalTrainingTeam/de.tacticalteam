<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InternController extends Controller
{
    public function index()
    {
        return view('intern.start');
    }
}
