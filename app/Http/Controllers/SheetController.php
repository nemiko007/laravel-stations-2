<?php

namespace App\Http\Controllers;

use App\Models\Sheet;
use Illuminate\View\View;

class SheetController extends Controller
{
    public function index(): View
    {
        $sheets = Sheet::all();
        return view('sheets.index', compact('sheets'));
    }
}