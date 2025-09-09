<?php

namespace App\Http\Controllers;

use App\Models\UbigeoPeruDepartment;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    public function index()
    {
        return UbigeoPeruDepartment::all();
    }
}
