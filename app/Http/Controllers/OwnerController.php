<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class OwnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $user = Auth::user();
        if($user->is_admin) {
            $owners = Owner::all();
        } else {
            $owners = $user->owners;
        }
        
        $rows = [];
        foreach($owners as $owner) {
            $rows[$owner->id] = [];
            $rows[$owner->id]['name'] = $owner->name;
            $rows[$owner->id]['actions'] = '<a href="/admin/owners/'.$owner->id.'/edit" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit"><i class="fa fa-lg fa-fw fa-pen"></i></a>';
        }

        $config = [
            'columns' => [null, ['orderable' => false]],
            'language' => ['url' => '/adminlte_localisation/sv_SE.json'],
        ];

        $data = [
            'rows' => $rows,
            'heads' => ['Namn', ''],
            'config' => $config,
        ];

        return view('admin.owners.index')->with($data);
    }

    public function edit(Owner $owner): View
    {
        $data = [
            'owner' => $owner,
        ];

        return view('admin.owners.edit')->with($data);
    }

    public function update(Request $request, Owner $owner): RedirectResponse
    {
        $owner->name = $request->name;
        $owner->infotext = $request->infotext;
        $owner->show_info_page = $request->show_info_page;
        $owner->save();

        return redirect('/admin/owners')->with('success', 'Ändringar sparade');
    }
}
