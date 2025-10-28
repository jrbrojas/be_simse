<?php

namespace App\Http\Controllers;

use App\Models\Distrito;
use Illuminate\Http\Request;

class DistritoController extends Controller
{
    public function index(Request $request)
    {
        return Distrito::all();
    }
}
