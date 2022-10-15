<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;
use App\Models\MyBodyTech\Invoice;
use App\Models\MyBodyTech\Payment;
use Illuminate\Support\Facades\DB;

class GenerateCashingRegisterDetailCase
{
    /**
     * Generate cashing register detail section
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public static function index($deferred_payments)
    {
        try {
            //code...
            DB::beginTransaction();
            $content = '';
            $counter = 0;
            $today = now()->format('Y-m-d H:i:s');
            foreach ($deferred_payments->cursor() as $row) {
                $row->load('customer:id,did,first_name,last_name');
                $row->load(['agreementLines' => function ($q) {
                    $q->with(['paymentMethod', 'agreement']);
                }]);

                $didCustomer = FormatString::fill($row->customer->did, '0', 48);
                $idCustomer = FormatString::fill($row->customer->id, '0', 30);
                $totalValue = FormatString::fill(number_format($row->amount, 2, '', ''), '0', 14);
                $deferredPaymentId = FormatString::fill('0', '0', 13);
                $valueServiceAditional = FormatString::fill('0', '0', 14);
                $dueDate = FormatString::fill(now()->parse($row->date)->format('Ymd'), '0', 13);
                $accountNumber = FormatString::fill($row->agreementLines->paymentMethod->account, '0', 17);
                $accountType = '0' . $row->agreementLines->paymentMethod->account_type; // 01 -> Ahorros | 02 -> Corriente
                $optionalDidCustomer = FormatString::fill($row->customer->did, '0', 10);
                $name = strtoupper($row->customer->first_name . ' ' . $row->customer->last_name);
                $nameCustomer = strlen($name) > 22 ? substr($name, 0, 22) : (strlen($name) ? $name . str_repeat(' ', 22 - strlen($name)) : $name);
                $whiteSpaceReseverd = FormatString::fill(' ', ' ', 24);

                $content .= implode([
                    '06',
                    $didCustomer,
                    $idCustomer,
                    '00',
                    '   ',
                    $totalValue,
                    $deferredPaymentId,
                    $valueServiceAditional,
                    $dueDate,
                    '00001007',
                    $accountNumber,
                    $accountType,
                    $optionalDidCustomer,
                    $nameCustomer,
                    '007',
                    $whiteSpaceReseverd,
                    "\n"
                ]);

                //generate Invoice
                $invoice = GenerateDraftInvoice::index($row);


                // generate payment
                $payment = new Payment();
                $payment->payment_date = $today;
                $payment->amount = $row->amount;
                $payment->payment_type_id = 2;
                $payment->num_payment = 1;
                $payment->status = 1;
                $payment->users_creator = 2661; //cambiar a usuario debito automatico
                $payment->create_at = $today;
                $payment->invoice_id = $invoice->id;
                $payment->create_at_db = $today;
                $payment->agreement_lines_id = $row->agreementLines->id;
                $payment->agreement_id = $row->agreementLines->agreement->id;
                $payment->payment_status = 2;
                $payment->brand_id = $row->agreementLines->agreement->brand_id;
                $payment->payment_method = $row->agreementLines->paymentMethod->id;
                $payment->transaction_method = 'automatic';
                $payment->bank_id = $row->agreementLines->paymentMethod->banks_id;
                $payment->save();

                $counter++;
            }
            DB::commit();

            return [$content, $counter];
        } catch (\Exception $ex) {
            DB::rollback();
            echo "\n" . 'Error>>>>>  ' .  $ex->getMessage();
        }
    }
}
