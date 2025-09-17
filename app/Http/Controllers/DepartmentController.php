<?php

namespace App\Http\Controllers;

use App\Models\Depa;

class DepartmentController extends Controller
{
    public function index()
    {
        return Depa::all();
    }
}
