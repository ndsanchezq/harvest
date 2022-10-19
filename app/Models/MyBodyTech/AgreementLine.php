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
     * Get the payment method associated with the agreement line.
     */
    public function agreement()
    {
        return $this->belongsTo(Agreement::class, 'agreement_id', 'id');
    }

    /**
     * Get all deferreds associated with the agreement line.
     */
    public function deferredsPayment()
    {
        return $this->hasMany(AgreementLineDeferredPayment::class, 'agreement_lines_id', 'id');
    }

    /**
     * Get all active agreement lines with his payments
     */
    public function scopeAccountsForValidating($query)
    {
        return $query->whereHas('paymentMethod', function ($q) {
            $q->whereNull('payment_method_validation_status')
                ->whereIn('account_type', [1, 2]);
        });
    }

    /**
     * Get recurring agreement lines
     */
    public function scopeIsRecurring($query)
    {
        return $query->whereHas('product', function ($q) {
            $q->where('is_recurring', 1);
        });
    }
}
