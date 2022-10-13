<?php

namespace App\Http\UseCases;

use App\Http\Utils\FormatString;
use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use Illuminate\Support\Facades\Storage;

class CashingFileCase
{
    /**
     * Generate cashing file
     * @author Neil David Sanchez Quintana
     * @return void
     */
    public static function generate()
    {
        $today = now()->format('Y-m-d');
        // Registro de encabezado del archivo y registro de encabezado del lote
        [$headerRules, $headerLotRules, $content] = GetHeaderRulesCase::index();

        // Prepare query
        $query = AgreementLineDeferredPayment::query()->active()->debito()->bancolombia();


        $counter = 0;
        foreach ($query->cursor() as $row) {
            $row->load('customer:id,did,first_name,last_name');
            $row->load(['agreementLines' => function ($q) {
                $q->with('paymentMethod');
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

            $counter++;
        }

        if ($counter < 1) {
            echo "No hay pagos pendientes para cuentas Bancolombia";
            return false;
        }

        $totalCount = FormatString::fill($query->count(), '0', 9);
        $totalAmountLot = FormatString::fill(number_format($query->sum('amount'), 2, '', ''), '0', 18);
        $totalAmountAditional = FormatString::fill('0', '0', 18);
        $totalWhiteSpaceReserved = FormatString::fill(' ', ' ', 173);

        $content .= implode([
            '08',
            $totalCount,
            $totalAmountLot,
            $totalAmountAditional,
            '0001',
            $totalWhiteSpaceReserved,
            "\n"
        ]);

        $content .= implode([
            '09',
            $totalCount,
            $totalAmountLot,
            $totalAmountAditional,
            $totalWhiteSpaceReserved
        ]);

        Storage::put('/BANCOLOMBIA/' . $today . '_BANCOLOMBIA_COBROS', $content);

        return true;
    }
}
