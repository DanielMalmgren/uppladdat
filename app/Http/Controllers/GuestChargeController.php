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
            $charging_session = new ChargingSession($charger);
            return redirect('/swish/pay?charging_session='.$charging_session->id);
        }
    }
}
