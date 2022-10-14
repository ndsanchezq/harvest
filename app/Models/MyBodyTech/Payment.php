<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'mybodytech';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'payment_date',
        'amount',
        'payment_type_id',
        'num_payment',
        'note',
        'status',
        'users_creator',
        'users_at_update',
        'created_at',
        'created_at_db',
        'agreement_lines_id',
        'agreement_id'
    ];
}
