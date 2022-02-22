<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charger;
use App\Models\ChargingSession;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class GuestChargeController extends Controller
{
    public function init(Request $request, Charger $charger): View|RedirectResponse
    {
        $charging_session = new ChargingSession();
        $charging_session->initialize($charger);

        if($charger->owner->show_info_page) {
            $data = [
                'charging_session' => $charging_session,
            ];
            return view('guest_charge.infopage')->with($data);
        } else {
            return redirect('/swish/pay?charging_session='.$charging_session->id);
        }
    }

    public function checkstatus(Request $request, ChargingSession $charging_session): string
    {
        return $charging_session->status;
    }

    public function success(Request $request): View|Response
    {
        $charging_session = ChargingSession::find($request->charging_session_id);

        if(!isset($charging_session)) {
            return response('Missing charging session id!', 400);
        }

        $data = [
            'end_at' => $charging_session->end_at,
        ];

        return view('guest_charge.success')->with($data);
    }

    public function failure(Request $request): View
    {
        $data = [
        ];

        return view('guest_charge.failure')->with($data);
    }

}
