<?php

namespace App\Http\UseCases;

use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use App\Models\MyBodyTech\Invoice;
use App\Models\MyBodyTech\InvoiceBillingRulling;
use App\Models\MyBodyTech\InvoiceLine;
use Exception;
use Illuminate\Support\Facades\Log;

class GenerateDraftInvoice
{
    public static function index(AgreementLineDeferredPayment $deferred_payment)
    {
        $today = now()->format('Y-m-d H:i:s');
        $invoice = new Invoice();
        $billing_rule = InvoiceBillingRulling::query()
            ->venueBillingRule(
                $deferred_payment->agreementLines->agreement->venue_id,
                $deferred_payment->agreementLines->agreement->company_id
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
        $invoice->create_at_db     = $today;
        $invoice->created_at       = $today;
        $invoice->update_at        = $today;
        $invoice->ref_ext          = 1;
        $invoice->customer_id      = $deferred_payment->agreementLines->agreement->customer_id;
        $invoice->brand_id         = $deferred_payment->agreementLines->agreement->brand_id ?? 1;
        $invoice->company_id       = $deferred_payment->agreementLines->agreement->company_id ?? 1;
        $invoice->organization_id  = $deferred_payment->agreementLines->agreement->organization_id ?? 1;
        $invoice->venue_id         = $deferred_payment->agreementLines->agreement->venue_id;
        $invoice->users_creator    = 2661; //cambiar a usuario debito automatico
        $invoice->assigned_executive = 2661; //cambiar a usuario debito automatico
        $invoice->assigned_executive_secundary = null;
        $invoice->status           = 1;
        $invoice->status_id        = "draft";
        $invoice->proposals_id     = null;
        $invoice->sales_channel_id = null;
        $invoice->invoice_billing_ruling_id = $billing_rule->id;
        $invoice->ref_consecutive  = 1;
        $invoice->agreement_id     = $deferred_payment->agreementLines->agreement->id;
        $invoice->invoice_type     = 1;
        $invoice->total_sub         = $deferred_payment->amount;
        $invoice->discount_percent  = 0;
        $invoice->discount_absolute = 0;
        $invoice->discount          = 0;
        $invoice->total_ht          = $deferred_payment->amount;
        $invoice->total_ttc         = $deferred_payment->amount;
        $invoice->save();
        $billing_rule->save();

        //invoice line
        $invoice_line = new InvoiceLine();
        $invoice_line->product_id = $deferred_payment->agreementLines->product->id;
        $invoice_line->products_prices_id = $deferred_payment->agreementLines->products_prices_id;
        $invoice_line->label = $deferred_payment->agreementLines->product->name;
        $invoice_line->total_sub = $deferred_payment->amount;;
        $invoice_line->discount_percent = 0;
        $invoice_line->discount_absolute = 0;
        $invoice_line->discount = 0;
        $invoice_line->total_ht = $deferred_payment->amount;
        $invoice_line->total_ttc = $deferred_payment->amount;
        $invoice_line->venue_id = $deferred_payment->agreementLines->agreement->venue_id;;
        $invoice_line->create_at = $today;
        $invoice_line->create_at_db = $today;
        $invoice_line->update_at = $today;
        $invoice_line->update_at_db = $today;
        $invoice_line->users_id = 2661; //cambiar por usuario debito automatico
        $invoice_line->members_id = $deferred_payment->agreementLines->members_id;
        $invoice_line->invoice_id = $invoice->id;
        $invoice_line->agreement_lines_id = $deferred_payment->agreementLines->id;
        $invoice_line->agreement_line_deferred_payment_id = $deferred_payment->id;
        $invoice_line->save();

        return $invoice;
    }
}
