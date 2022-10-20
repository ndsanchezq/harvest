<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\MyBodyTech\AgreementLineDeferredPayment;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function index()
    {
        $deferred_payments = AgreementLineDeferredPayment::query()
            ->active()->mercadoPago();

        if ($deferred_payments->count() > 1) {
            return redirect()->route('dashboard')->with('success', 'No hay pagos pendientes');
        }

        return redirect()->route('payments.index')->with('success', 'No hay pagos pendientes');
    }
}
