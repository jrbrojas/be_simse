<?php

namespace App\Http\Controllers\Monitoreo;

use App\Http\Controllers\Controller;
use App\Models\Monitoreo\EntidadRegistrada;

class EntidadRegistradaController extends Controller
{
    public function getEntidad(int $entidad)
    {
        $e = EntidadRegistrada::query()->with(['entidad', 'categoria'])->where('id', $entidad)->firstOrFail();
        return $e;
    }
}
