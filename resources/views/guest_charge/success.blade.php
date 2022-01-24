@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    Tack för din betalning!
                </div>

                <div class="card-body">

                    Laddaren aktiveras nu.<br><br>

                    @isset($end_at)
                        Du kan ladda fram till {{$end_at->format('H:i')}}<br><br>
                    @endisset

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
