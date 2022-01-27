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

        $data = [
            'payments' => $payments,
            'heads' => ['Datum/tid', 'Betalare', 'Summa', 'status'],
        ];

        return view('admin.payments')->with($data);
    }
}
