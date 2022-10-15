<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\Invoice;
use App\Models\MyBodyTech\InvoiceBillingRulling;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateDraftInvoice
{
    public static function index($deferred_payment)
    {
        $invoice = new Invoice();
        $billing_rule = InvoiceBillingRulling::query()
            ->venueBillingRule(
                $deferred_payment->agreement_line->agreement->venue_id,
                $deferred_payment->agreement_line->agreement->company_id
            )
            ->first();

        if (!$billing_rule) {
            $message = 'La sede no tiene una resolucion de facturacion definida';
            Log::error($message);
            throw new Exception($message, 1);
        }

        $consecutive = (int)$billing_rule->current_number + 1;
        $billing_rule->current_number = $consecutive;

        $invoice->ref = $billing_rule->prefix . $consecutive;
        $invoice->consecutive =  $consecutive;
        $invoice->create_at_db     = now()->format('Y-m-d H:i:s');
        $invoice->created_at       = now()->format('Y-m-d H:i:s');
        $invoice->update_at        = now()->format('Y-m-d H:i:s');
        $invoice->ref_ext          = 1;
        $invoice->customer_id      = $deferred_payment->agreement_line->agreement->customer_id;
        $invoice->brand_id         = $deferred_payment->agreement_line->agreement->brand_id ?? 1;
        $invoice->company_id       = $deferred_payment->agreement_line->agreement->company_id ?? 1;
        $invoice->organization_id  = $deferred_payment->agreement_line->agreement->organization_id ?? 1;
        $invoice->venue_id         = $deferred_payment->agreement_line->agreement->venue_id;
        $invoice->users_creator    = 2661; //cambiar a usuario debito automatico
        $invoice->assigned_executive = 2661; //cambiar a usuario debito automatico
        $invoice->assigned_executive_secundary = null;
        $invoice->status           = 1;
        $invoice->status_id        = "draft";
        $invoice->proposals_id     = null;
        $invoice->sales_channel_id = null;
        $invoice->invoice_billing_ruling_id = $billing_rule->id;
        $invoice->ref_consecutive  = 1;
        $invoice->agreement_id     = $deferred_payment->agreement_line->agreement->id;
        $invoice->invoice_type     = 1;
        $invoice->total_sub         = $deferred_payment->amount;
        $invoice->discount_percent  = 0;
        $invoice->discount_absolute = 0;
        $invoice->discount          = 0;
        $invoice->total_ht          = $deferred_payment->amount;
        $invoice->total_ttc         = $deferred_payment->amount;
        $invoice->save();
        $billing_rule->save();

        return $invoice;
    }
}
