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
        'payment_reason_rejection',
        'franchise_id'
    ];

    /**
     * Get the agreement associated with the payment.
     */
    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id', 'id');
    }

    /**
     * Get the payment type associated with the payment.
     */
    public function type()
    {
        return $this->hasOne(PaymentType::class, 'id', 'payment_type_id');
    }

    /**
     * Get invoice associated with the payment.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
