<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Models\FileHeaderRule, App\Models\FileLotHeaderRule;
use App\Models\MyBodyTech\AgreementLineDeferredPayment;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/status', function () {
    // Validations
    $headerRules = FileHeaderRule::where('bank_id', 4)->first();
    if (!$headerRules instanceof FileHeaderRule) {
        Log::error('No fue posible recuperar el encabezado del archivo');
    }

    $headerLotRules = FileLotHeaderRule::where('bank_id', 4)->first();
    if (!$headerLotRules instanceof FileLotHeaderRule) {
        Log::error('No fue posible recuperar el encabezado de lote del archivo');
    }

    // Header file
    $content = implode([
        $headerRules->register_type_value,
        $headerRules->did_main_collector_company_value,
        $headerRules->did_additional_collector_company_value,
        $headerRules->financial_entity_code_value,
        now()->format('YmdHi'),
        'A',
        str_repeat(' ', $headerRules->reserved_white_spaces),
        "\n"
    ]);

    // Header lot
    $content .= implode([
        $headerLotRules->register_type_value,
        $headerLotRules->invoiced_service_code_value,
        $headerLotRules->lot_number_value,
        $headerLotRules->invoiced_service_description_value,
        str_repeat(' ', $headerLotRules->reserved_white_spaces),
        "\n"
    ]);

    function validateAndFormatRow ($string, $character, $length) {
        return strlen($string) < $length
            ? str_repeat($character, $length - strlen($string)) . $string
            : $string;
    }

    // Prepare query
    $query = AgreementLineDeferredPayment::query();
    $query->active();
    $query->debito();

    foreach ($query->cursor() as $row) {
        $row->load('customer:id,did,first_name,last_name');
        $row->load(['agreementLines' => function ($q) {
            $q->with('paymentMethod');
        }]);

        $didCustomer = validateAndFormatRow($row->customer->did, '0', 48);
        $idCustomer = validateAndFormatRow($row->customer->id, '0', 30);
        $totalValue = validateAndFormatRow(number_format($row->amount, 2, '', ''), '0', 14);
        $deferredPaymentId = validateAndFormatRow('0', '0', 13);
        $valueServiceAditional = validateAndFormatRow('0', '0', 14);
        $dueDate = validateAndFormatRow(now()->parse($row->date)->format('Ymd'), '0', 13);
        $accountNumber = validateAndFormatRow($row->agreementLines->paymentMethod->account, '0', 17);
        $accountType = '0' . $row->agreementLines->paymentMethod->account_type; // 01 -> Ahorros | 02 -> Corriente
        $optionalDidCustomer = validateAndFormatRow($row->customer->did, '0', 10);
        $name = strtoupper($row->customer->first_name . ' ' . $row->customer->last_name);
        $nameCustomer = strlen($name) > 22 ? substr($name, 0, 22) : (strlen($name) ? $name . str_repeat(' ', 22 - strlen($name)) : $name);
        $whiteSpaceReseverd = validateAndFormatRow(' ', ' ', 24);

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
    }

    $totalCount = validateAndFormatRow($query->count(), '0', 9);
    $totalAmountLot = validateAndFormatRow(number_format($query->sum('amount'), 2, '', ''), '0', 18);
    $totalAmountAditional = validateAndFormatRow('0', '0', 18);
    $totalWhiteSpaceReserved = validateAndFormatRow(' ', ' ', 173);

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

    Storage::put('file.txt', $content);

    return response(['message' => 'Holi'], 200);
});
