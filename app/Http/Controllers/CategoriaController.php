<?php

namespace App\Http\Controllers;

use App\Models\Directorio\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        return Categoria::all();
    }
}
