@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    Välkommen till {{$charging_session->charger->owner->name}}!
                </div>

                <div class="card-body">

                    {{$charging_session->charger->owner->infotext}}

                    <br><br>

                    <a href="/swish/pay?charging_session={{$charging_session->id}}" class="btn btn-primary">Gå till betalning</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
