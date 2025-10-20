<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

final class WidgetController 
{
    public function index(): View
    {
        return view('widget.index');
    }
}