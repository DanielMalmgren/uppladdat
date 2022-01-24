<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charger;
use App\Models\ChargingSession;

class GuestChargeController extends Controller
{
    public function init(Request $request, Charger $charger)
    {
        if($charger->owner->show_info_page) {
            //TODO: Fixa info-sidan, visa den här
        } else {
            $charging_session = new ChargingSession();
            $charging_session->initialize($charger);
            return redirect('/swish/pay?charging_session='.$charging_session->id);
        }
    }

    public function checkstatus(Request $request, ChargingSession $charging_session)
    {
        return $charging_session->status;
    }

    public function success(Request $request)
    {
        $charging_session = ChargingSession::find($request->charging_session_id);

        if(isset($charging_session)) {
            $end_at = $charging_session->end_at;
        }

        $data = [
            'end_at' => $end_at,
        ];

        return view('guest_charge.success')->with($data);
    }

    public function failure(Request $request)
    {
        $data = [
        ];

        return view('guest_charge.failure')->with($data);
    }

}
