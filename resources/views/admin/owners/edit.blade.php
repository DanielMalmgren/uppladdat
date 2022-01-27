@extends('adminlte::page')

@section('title', 'uppladd.at admin')

@section('content_header')
    <h1 class="m-0 text-dark">Inställningar för ägare</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{action('App\Http\Controllers\OwnerController@update', $owner->id)}}" accept-charset="UTF-8">
                        @method('put')
                        @csrf

                        <div class="row">
                            <x-adminlte-input name="name" label="Namn" value="{{$owner->name}}" fgroup-class="col-md-6" enable-old-support/>
                        </div>

                        <div class="row">
                            <x-adminlte-textarea name="infotext" label="Infotext till kunder" value="{{$owner->infotext}}" fgroup-class="col-md-6" enable-old-support/>
                        </div>

                        <x-adminlte-button type="submit" label="Spara" theme="success" icon="fas fa-lg fa-save"/>    
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
