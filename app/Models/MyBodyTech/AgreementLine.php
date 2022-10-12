<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementLine extends Model
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
    protected $table = 'agreement_lines';

    /**
     * Get the product associated with the agreement line.
     */
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    /**
     * Get the payment method associated with the agreement line.
     */
    public function paymentMethod()
    {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    /**
     * Get all deferreds associated with the agreement line.
     */
    public function deferredsPayment()
    {
        return $this->hasMany(AgreementLineDeferredPayment::class, 'agreement_lines_id', 'id');
    }
}
