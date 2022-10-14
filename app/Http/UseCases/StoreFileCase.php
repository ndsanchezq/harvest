<?php

namespace App\Http\UseCases;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class StoreFileCase
{
    public static function index($file_name, $path, $content, $modifier, $lines_number, $file_type)
    {
        $today = now()->format('Y-m-d');
        $file = Storage::put($path, $content);
        if ($file) {
            $payload = [
                'name' => $file_name,
                'path' => $path,
                'delivery_date' => $today,
                'modifier' => $modifier,
                'size' => Storage::size($path),
                'lines_number' => $lines_number,
                'bank_id' => 4,
                'file_type' => $file_type,
                'file_status' => 'completed',
            ];
            File::create($payload);
        }

        return $file;
    }
}
