<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charger;

class ChargerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //TODO: Only return the chargers that the current user has permissions for!

        $chargers = [];
        foreach(Charger::all() as $charger) {
            $chargers[$charger->id] = [];
            $chargers[$charger->id]['designation'] = $charger->designation;
            $chargers[$charger->id]['api'] = $charger->api;
            $chargers[$charger->id]['price_per_hour'] = $charger->price_per_hour.' kr';
            $chargers[$charger->id]['actions'] = '<a href="/admin/chargers/'.$charger->id.'/edit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Inställningar"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
        }

        $config = [
            'columns' => [null, null, null, ['orderable' => false]],
            'language' => ['url' => '/adminlte_localisation/sv_SE.json'],
        ];

        $data = [
            'rows' => $chargers,
            'heads' => ['Namn', 'API', 'Pris per timme', ''],
            'config' => $config,
        ];

        return view('admin.chargers.index')->with($data);
    }

    public function edit(Charger $charger)
    {
        \App::setLocale('sv');

        $data = [
            'charger' => $charger,
        ];

        return view('admin.chargers.edit')->with($data);
    }

    public function update(Request $request, Charger $charger)
    {
        $charger->designation = $request->designation;
        $charger->price_per_hour = $request->price_per_hour;
        $charger->save();

        return redirect('/admin/chargers')->with('success', 'Ändringar sparade');
    }
}
