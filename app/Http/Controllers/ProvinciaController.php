<?php

namespace App\Http\Controllers;

use App\Models\Prov;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    public function index(Request $request)
    {
        return Prov::query()
            ->when($request->get('name'), function ($query, $name) {
                $query->where('nomdpto', $name);
            })
            ->get();
    }
}
