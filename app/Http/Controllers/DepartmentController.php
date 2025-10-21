<?php

namespace App\Http\Controllers;

use App\Models\Departamento;

class DepartmentController extends Controller
{
    public function index()
    {
        return Departamento::all();
    }
}
