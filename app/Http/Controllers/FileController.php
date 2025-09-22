<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show(File $file)
    {
        return Storage::disk($file->disk)->response($file->path);
    }
}
