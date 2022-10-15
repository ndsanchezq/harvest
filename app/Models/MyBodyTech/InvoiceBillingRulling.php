<?php

namespace App\Models\MyBodyTech;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceBillingRulling extends Model
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
    protected $table = 'invoice_billing_ruling';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_oficial_company',
        'name_comercial_company',
        'commercial_brand',
        'number_start',
        'number_end',
        'venue_id',
        'date_start',
        'date_end',
        'prefix',
        'company_id',
        'description',
        'text_pdf',
        'note_public',
        'users_creator',
        'users_modify',
        'create_at',
        'create_at_db',
        'update_at',
        'update_at_db',
        'ciiu',
        'current_number',
        'prefix_nc',
        'status',
        'billing_rule_status',
    ];

    /**
     * get biiling rule for venue
     */
    public function scopeVenueBillingRule($query, $venue_id, $company_id)
    {
        return $query->where([
            ['venue_id', '=', $venue_id],
            ['company_id', '=', $company_id],
        ])->whereNotNull('prefix_nc');
    }
}
