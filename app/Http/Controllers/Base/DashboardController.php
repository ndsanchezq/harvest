<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\MyBodyTech\Payment;
use App\Models\MyBodyTech\PaymentMethod;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Dates between
        $start_of_week = now()->startOfWeek();
        $end_of_week = now()->endOfWeek();

        // Payments made
        $query = Payment::query();
        $query->where('transaction_method', 'automatic');
        $query->where('payment_status', 1);
        $payments_made = $query->count();

        // Payments in process
        $query = Payment::query();
        $query->where('transaction_method', 'automatic');
        $query->where('payment_status', 2);
        $payments_in_process = $query->count();

        // Accounts in process
        $query = PaymentMethod::query();
        $query->where('payment_method_validation_status', 'en proceso');
        $query->whereIn('account_type', [1, 2]);
        $accounts_in_process = $query->count();

        // Validates accounts
        $query = PaymentMethod::query();
        $query->where('payment_method_validation_status', 'validada');
        $query->whereIn('account_type', [1, 2]);
        $validates_accounts = $query->count();

        // Mercado pago
        $query = Payment::query();
        $query->where('transaction_method', 'automatic');
        $query->where('payment_status', 1);
        $query->whereBetween('payment_date', [$start_of_week, $end_of_week]);
        $mercado_pago = $query->sum('amount');

        // Bank debit
        $query = Payment::query();
        $query->where('transaction_method', 'automatic');
        $query->where('payment_status', 1);
        $query->whereBetween('payment_date', [$start_of_week, $end_of_week]);
        $bank_debit = $query->sum('amount');

        // FIles
        $query = File::query();
        $query->whereBetween('created_at', [$start_of_week, $end_of_week]);
        $files = $query->count();

        return inertia(
            'Dashboard',
            compact('payments_made', 'payments_in_process', 'accounts_in_process', 'validates_accounts', 'mercado_pago', 'bank_debit', 'files')
        );
    }
}
