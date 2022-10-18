<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\ResponseFile;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use DB, Log;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $files = File::where('status', 1)->get();
        return inertia('Files/Index', ['files' => $files]);
    }

    public function show(File $file)
    {
        return Storage::download($file->path);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('file')) {
            DB::beginTransaction();
            try {
                // Get file
                $file = file($request->file->getPathname());

                if (count($file) <= 4) {
                    throw new \Exception('El archivo no es valido.');
                }

                // Prepare to read file
                $responseFile = new ResponseFile;
                $responseFile->prepareToReadFile($file);

                DB::commit();
                return redirect()->route('files.index');
            } catch (\Exception $e) {
                DB::rollback();
                Log::error($e->getMessage());
                throw ValidationException::withMessages([$e->getMessage()]);
            }
        }
    }
}
