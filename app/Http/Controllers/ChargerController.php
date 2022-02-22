<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charger;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ChargerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = Auth::user();
        if($user->is_admin) {
            $chargers = Charger::all();
        } else {
            $chargers = $user->chargers;
        }

        $rows = [];
        foreach($chargers as $charger) {
            $rows[$charger->id] = [];
            $rows[$charger->id]['designation'] = $charger->designation;
            $rows[$charger->id]['api'] = $charger->api;
            $rows[$charger->id]['price_per_hour'] = $charger->price_per_hour.' kr';
            $rows[$charger->id]['actions'] = '<a href="/admin/chargers/'.$charger->id.'/edit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Inställningar"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
        }

        $config = [
            'columns' => [null, null, null, ['orderable' => false]],
            'language' => ['url' => '/adminlte_localisation/sv_SE.json'],
        ];

        $data = [
            'rows' => $rows,
            'heads' => ['Namn', 'API', 'Pris per timme', ''],
            'config' => $config,
        ];

        return view('admin.chargers.index')->with($data);
    }

    public function edit(Charger $charger): View
    {
        \App::setLocale('sv');

        $data = [
            'charger' => $charger,
        ];

        return view('admin.chargers.edit')->with($data);
    }

    public function update(Request $request, Charger $charger): RedirectResponse
    {
        $charger->designation = $request->designation;
        $charger->price_per_hour = $request->price_per_hour;
        $charger->save();

        return redirect('/admin/chargers')->with('success', 'Ändringar sparade');
    }
}
