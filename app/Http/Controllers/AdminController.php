<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function payments()
    {
        //TODO: Only return the payments that the current user has permissions for!
        //TODO: Return which charger it corresponds to
        $payments = Payment::all()->map->only(['created_at', 'payerAlias', 'amount', 'status'])->toArray();

        $payments = [];
        foreach(Payment::all() as $payment) {
            $payments[$payment->id] = [];
            $payments[$payment->id]['created_at'] = $payment->created_at;
            $payments[$payment->id]['payerAlias'] = $payment->payerAlias;
            $payments[$payment->id]['amount'] = $payment->amount.' kr';
            $payments[$payment->id]['status'] = $payment->status;
            $payments[$payment->id]['actions'] = '<a href="/swish/refund?originalPaymentReference='.$payment->id.'" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Återbetala"><i class="fas fa-lg fa-fw fa-undo"></i></a>';
        }

        $config = [
            'columns' => [null, null, null, null, ['orderable' => false]],
            'language' => ['url' => '/adminlte_localisation/sv_SE.json'],
        ];

        $data = [
            'payments' => $payments,
            'heads' => ['Datum/tid', 'Betalare', 'Summa', 'status', ''],
            'config' => $config,
        ];

        return view('admin.payments.index')->with($data);
    }
}
