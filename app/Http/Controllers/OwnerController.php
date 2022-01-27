<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //TODO: Only return the owners that the current user has permissions for!

        $owners = [];
        foreach(Owner::all() as $owner) {
            $owners[$owner->id] = [];
            $owners[$owner->id]['name'] = $owner->name;
            $owners[$owner->id]['actions'] = '<a href="/admin/owners/'.$owner->id.'/edit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
        }

        $config = [
            'columns' => [null, ['orderable' => false]],
            'language' => ['url' => '/adminlte_localisation/sv_SE.json'],
        ];

        $data = [
            'rows' => $owners,
            'heads' => ['Namn', ''],
            'config' => $config,
        ];

        return view('admin.owners.index')->with($data);
    }

    public function edit(Owner $owner)
    {
        $data = [
            'owner' => $owner,
        ];

        return view('admin.owners.edit')->with($data);
    }

    public function update(Request $request, Owner $owner)
    {
        $owner->name = $request->name;
        $owner->save();

        return redirect('/admin/owners')->with('success', 'Ändringar sparade');
    }
}
