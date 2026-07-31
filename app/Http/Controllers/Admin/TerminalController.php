<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class TerminalController extends Controller
{
    public function index(): View
    {
        return view('admin.terminal.index');
    }
}