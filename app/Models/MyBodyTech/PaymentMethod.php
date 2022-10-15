<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
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
    protected $table = 'payment_method';

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
        $query->where('account_type', '<>', 0)->where('payment_method_validation_status', 'pendiente')->whereNotNull('banks_id');
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
