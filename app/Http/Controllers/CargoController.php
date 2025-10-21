<?php

namespace App\Http\Controllers;

use App\Models\Directorio\Cargo;

class CargoController extends Controller
{
    public function index()
    {
        return Cargo::all();
    }
}
