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
}
