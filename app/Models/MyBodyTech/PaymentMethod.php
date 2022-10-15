<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
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
    protected $table = 'payment_method';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_id',
        'bank',
        'account',
        'account_type',
        'token_credit_card',
        'ref_external',
        'name_credit_card',
        'last_four_number',
        'due_date_cc',
        'name_cc',
        'dni_cc',
        'type',
        'banks_id',
        'email',
        'document_type',
        'six_firts_number',
        'plarform',
        'payment_method_status',
        'payment_method_validation_status',
        'payment_method_validation_date',
        'payment_method_reason_rejection',
        'payment_reason_rejection'
    ];

    /**
     * Get customer associated with the payment method.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * get accounts for validationg
     */
    public function scopeAccountsForValidating($query)
    {
        // payment_method_validation_status = 'pendiente'
        $query->where('account_type', '<>', 0)->where('payment_method_validation_status', 1)->whereNotNull('banks_id');
    }

    /**Get only bancolombia accounts */
    public function scopeBancolombia($query)
    {
        $query->where('banks_id', 4);
    }

    /**Get other banks accounts */
    public function scopeOtherBanks($query)
    {
        $query->where('banks_id', '<>', 4);
    }
}
