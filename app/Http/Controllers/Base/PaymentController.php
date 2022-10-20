<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\MyBodyTech\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Payment::query();
        $query->where('transaction_method', 'automatic');
        $query->where('payment_status', 1);
        $query->with(['invoice:id,pdf', 'type:id,label', 'agreement' => function ($q) {
            $q->select('id', 'customer_id')
                ->with('customer:id,first_name,last_name');
        }]);
        $payments = $query->get();

        return inertia('Payments', compact('payments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}
