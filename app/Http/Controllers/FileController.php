<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index()
    {
        $files = File::where('status', 1)->orderBy('id', 'desc')->take(5)->get();
        return inertia('Files/List', ['files' => $files]);
    }

    public function getFile($id)
    {
        $file = File::findOrFail($id);

        return Storage::download($file->path);
    }
}