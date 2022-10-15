<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLine extends Model
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
    protected $table = 'invoice_lines';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'products_prices_id',
        'label',
        'description',
        'id_sales_offers',
        'total_sub',
        'discount_percent',
        'discount_absolute',
        'discount',
        'total_ht',
        'tva',
        'totaltax1',
        'totaltax2',
        'total_ttc',
        'id_currency',
        'multicurrency_code',
        'multicurrency_tx',
        'multicurrency_total_ht',
        'multicurrency_total_tva',
        'multicurrency_total_ttc',
        'venue_id',
        'create_at',
        'create_at_db',
        'update_at',
        'update_at_db',
        'users_id',
        'crm_leads_id',
        'members_id',
        'invoice_id',
        'proposals_lines_id',
        'agreement_lines_id',
        'category_venue_id',
        'coupon_id',
        'buy_member_status_id',
        'buy_product_status_id',
        'agreement_line_deferred_payment_id'
    ];

    /**
     * Get associated invoice
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
