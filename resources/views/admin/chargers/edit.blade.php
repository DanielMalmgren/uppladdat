@extends('adminlte::page')

@section('title', 'uppladd.at admin')

@section('content_header')
    <h1 class="m-0 text-dark">Inställningar för laddare</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form method="post" action="{{action('App\Http\Controllers\ChargerController@update', $charger->id)}}" accept-charset="UTF-8">
                        @method('put')
                        @csrf

                        <div class="row">
                            <x-adminlte-input name="designation" label="Namn" value="{{$charger->designation}}" fgroup-class="col-md-6" enable-old-support/>
                        </div>

                        <div class="row">
                            <x-adminlte-input name="price_per_hour" label="Pris per timme" value="{{$charger->price_per_hour}}" type="number" min=0 max=1000 step=".01" fgroup-class="col-md-6" enable-old-support/>
                        </div>

                        <x-adminlte-button type="submit" label="Spara" theme="success" icon="fas fa-lg fa-save"/>    
                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
