<?php

namespace App\Http\Controllers;

use App\Models\Directorio\RolesResponsable;

class RolesResponsableController extends Controller
{
    public function index()
    {
        return RolesResponsable::all();
    }
}
