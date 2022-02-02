@extends('adminlte::page')

@section('title', 'uppladd.at admin')

@section('content_header')
    <h1 class="m-0 text-dark">Betalningar</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <x-adminlte-datatable id="table1" :heads="$heads" :config="$config">
                        @foreach($payments as $payment)
                            <tr>
                                @foreach($payment as $cell)
                                    <td>{!! $cell !!}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop
