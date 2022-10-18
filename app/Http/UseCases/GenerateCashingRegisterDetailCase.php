<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;
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
                    $q->with(['paymentMethod', 'agreement', 'product']);
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
                $name = strtoupper(FormatString::removeAccents($row->customer->first_name . ' ' . $row->customer->last_name));
                $nameCustomer = FormatString::fill($name, ' ', 22, true);
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

                //generate invoice
                $invoice = GenerateDraftInvoice::index($row);

                // generate payment
                $payment = GeneratePaymentCase::index($row, $invoice, 2);

                $counter++;
            }
            DB::commit();

            return [$content, $counter];
        } catch (\Exception $ex) {
            DB::rollback();
            echo "\n" . 'Error>>>>>  ' .  $ex->getMessage() . ' on line ' . $ex->getLine();
        }
    }
}
