<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSetHeaderRule extends Model
{
    use HasFactory;

    /** Disable timestamps */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'register_type_value',
        'register_type_lenght',
        'invoiced_service_code_value',
        'invoiced_service_code_lenght',
        'lot_number_value',
        'lot_number_lenght',
        'invoiced_service_description_value',
        'invoiced_service_description_length',
        'reserved_white_spaces',
        'bank_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
