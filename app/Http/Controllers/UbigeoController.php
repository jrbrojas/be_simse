<?php

namespace App\Http\Controllers;

use App\Models\Ubigeo;

class UbigeoController extends Controller
{
    public function ubigeo()
    {
        $data = Ubigeo::all();
    }
}
