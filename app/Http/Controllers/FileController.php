<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Seguimiento\SeguimientoFile;
use App\Models\Supervision\SupervisionFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function file(File $file)
    {
        return Storage::disk($file->disk)->response($file->path);
    }

    public function show($type, $id)
    {
        if ($type === 'monitoreo') {
            $file = File::findOrFail($id);
        } elseif ($type === 'seguimiento') {
            $file = SeguimientoFile::findOrFail($id);
        } elseif ($type === 'supervision') {
            $file = SupervisionFile::findOrFail($id);
        } else {
            abort(404, "Tipo de archivo no válido");
        }

        return Storage::disk($file->disk)->response($file->path);
    }
}


