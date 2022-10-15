<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
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
    protected $table = 'invoice';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ref',
        'ref_ext',
        'consecutive',
        'customer_id',
        'crm_leads_id',
        'brand_id',
        'company_id',
        'organization_id',
        'venue_id',
        'users_creator',
        'users_validate',
        'users_close',
        'status',
        'status_id',
        'total_sub',
        'discount_percent',
        'discount_absolute',
        'discount',
        'total_ht',
        'tva',
        'localtax1',
        'localtax2',
        'total_ttc',
        'id_currency',
        'multicurrency_code',
        'multicurrency_tx',
        'multicurrency_total_ht',
        'multicurrency_total_tva',
        'multicurrency_total_ttc',
        'created_at',
        'create_at_db',
        'update_at',
        'sales_source_id',
        'sales_channel_id',
        'sales_segment_id',
        'note_private',
        'note_public',
        'due_date',
        'crm_deals_id',
        'agreement_id',
        'proposals_id',
        'invoice_type',
        'invoice_billing_ruling_id',
        'assigned_executive',
        'assigned_executive_secundary',
        'ref_consecutive',
        'invoice_id',
        'pdf',
        'coupon_id',
        'status_send_gp',
        'status_send_electronic',
        'credit_note_type'
    ];
}
