<?php

namespace App\Http\Controllers\Monitoreo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Monitoreo\RespuestaStore;
use App\Models\Monitoreo\EntidadRegistrada;
use App\Models\Monitoreo\RespuestasPreguntas;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MonitoreoController extends Controller
{
    public function index()
    {
        return EntidadRegistrada::with(['entidad', 'respuestas'])->get();
    }
}
