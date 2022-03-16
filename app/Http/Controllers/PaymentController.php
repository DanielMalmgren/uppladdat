<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        if($user->is_admin) {
            $payments = Payment::all();
        } else {
            $payments = $user->payments;
        }

        $rows = [];
        foreach($payments as $payment) {
            $rows[$payment->id] = [];
            $rows[$payment->id]['created_at'] = $payment->created_at;
            $rows[$payment->id]['payerAlias'] = $payment->payerAlias;
            $rows[$payment->id]['amount'] = $payment->amount.' kr';
            $rows[$payment->id]['status'] = $payment->status;
            $rows[$payment->id]['actions'] = '<a href="#" onclick="refund(\''.$payment->id.'\',\''.$payment->amount.'\')" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Återbetala"><i class="fas fa-lg fa-fw fa-undo"></i></a>'.
                                                '<a href="/admin/chargers/'.$payment->charging_session->charger->id.'/edit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Gå till laddare"><i class="fas fa-lg fa-fw fa-charging-station"></i></a>';
        }

        $config = [
            'columns' => [null, null, null, null, ['orderable' => false]],
            'language' => ['url' => '/adminlte_localisation/sv_SE.json'],
        ];

        $data = [
            'payments' => $rows,
            'heads' => ['Datum/tid', 'Betalare', 'Summa', 'status', ''],
            'config' => $config,
        ];

        return view('admin.payments.index')->with($data);
    }
}
