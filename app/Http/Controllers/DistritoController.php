<?php

namespace App\Http\Controllers;

use App\Models\UbigeoPeruDistrict;
use Illuminate\Http\Request;

class DistritoController extends Controller
{
    public function index()
    {
        return UbigeoPeruDistrict::all();
    }
}
