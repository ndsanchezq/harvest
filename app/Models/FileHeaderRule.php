<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileHeaderRule extends Model
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
        'did_main_collector_company_value',
        'did_main_collector_company_lenght',
        'did_additional_collector_company_value',
        'did_additional_collector_company_lenght',
        'financial_entity_code_value',
        'financial_entity_code_length',
        'reserved_white_spaces',
        'file_type',
        'bank_id'
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
