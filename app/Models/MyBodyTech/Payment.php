<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * disable timestamps
     * 
     * @var boolean
     */
    public $timestamps = false;

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
        'create_at',
        'create_at_db',
        'update_at',
        'agreement_lines_id',
        'agreement_id',
        'payment_status',
        'brand_id',
        'source_payment',
        'payment_method_id',
        'box_id',
        'transaction_method',
        'voucher_number',
        'bank_id',
        'invoice_id',
        'card_cd',
        'franchise_id'
    ];
}
