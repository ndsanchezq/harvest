<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Classes\ResponseFile;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return inertia('Files/Index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('response')) {
            $responseFile = new ResponseFile;

            $file = file($request->response->getPathname());

            $responseFile->getHeaderFile($file[0]);
            $responseFile->getHeaderLot($file[1]);
            $responseFile->getFooterLot($file[count($file) - 2]);
            $responseFile->getFooterFile($file[count($file) - 1]);

            foreach ($file as $key => $value) {
                if ($key > 1 && $key < count($file) - 2) $responseFile->getContent($value);
            }
        }
    }
}
