<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function file(File $file)
    {
        return Storage::disk($file->disk)->response($file->path);
    }

    public function show($type, $id)
    {
        $file = File::query()->findOrFail($id);

        return Storage::disk($file->disk)->response($file->path);
    }
}


