<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgreementLineDeferredPayment extends Model
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
    protected $table = 'agreement_line_deferred_payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agreement_lines_id',
        'date',
        'start_date_of_use',
        'amount',
        'status',
        'payment_status',
        'customer_id',
        'invoice_id',
    ];

    /**
     * Get customer associated with the payment method.
     */
    public function agreementLines()
    {
        return $this->belongsTo(AgreementLine::class, 'agreement_lines_id', 'id');
    }

    /**
     * Get customer associated with the payment method.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    /**
     * Get customer associated with the payment method.
     */
    public function invoiceLines()
    {
        return $this->belongsTo(InvoiceLine::class, 'id', 'agreement_line_deferred_payment_id');
    }

    /**
     * Scope a query to only include agreements actives
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where([
            ['date', '<=', now()],
            ['status', '=',  1],
            ['amount', '<>', 0],
            ['payment_status', '=', 0]
        ]);
    }

    /**
     * Scope a query to only include agreements of debit
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDebito($query)
    {
        return $query->whereHas('agreementLines', function ($q) {
            $q->where('line_status', 1)
                ->whereNotNull('payment_method_id')
                ->whereHas('paymentMethod', function ($subq) {
                    $subq->whereIn('account_type', [1, 2])
                        ->where('payment_method_validation_status', 'validada');
                });
        });
    }

    /**
     * Scope a query to include payments with no process or rejected
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotPaymentInProcess($query)
    {
        return $query->whereHas('invoiceLines', function ($invoice_line_query) {
            $invoice_line_query->whereHas('invoice', function ($invoice_query) {
                $invoice_query->whereHas('payment', function ($payment_query) {
                    $payment_query->whereNull('id')->orWhereIn('payment_status', [4, 5]);
                });
            });
        });
    }

    /**
     * Scope a query to only include agreements of payment market
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMercadoPago($query)
    {
        return $query->whereHas('agreementLines', function ($q) {
            $q->where('line_status', 1)
                ->whereNotNull('payment_method_id')
                ->whereHas('paymentMethod', function ($subq) {
                    $subq->where('account_type', 0);
                });
        });
    }

    /**
     * get only bancolombia accounts
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBancolombia($query)
    {
        return $query->whereHas('agreementLines', function ($q) {
            $q->whereHas('paymentMethod', function ($subq) {
                $subq->where('banks_id', 4);
            });
        });
    }

    /**
     * get ACH accounts
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOtherBanks($query)
    {
        return $query->whereHas('agreementLines', function ($q) {
            $q->whereHas('paymentMethod', function ($subq) {
                $subq->where('banks_id', '<>', 4);
            });
        });
    }
}
