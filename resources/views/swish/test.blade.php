@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    Skickar Swish-förfrågan!
                </div>

                <div class="card-body">

                    Om allt fungerar borde du nu få upp Swish-appen i din telefon.<br>

                    ID: {{$id}}<br>

                    Eller så klickar du här för att starta den manuellt:<br>
                    <a href="swish://paymentrequest?token={{$id}}&callbackurl={{urlencode(env('APP_URL').'/swish/postpay')}}">swish://paymentrequest?token={{$id}}&callbackurl={{urlencode(env('APP_URL').'/swish/postpay')}}</a>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.location = "swish://paymentrequest?token={{$id}}&callbackurl={{urlencode(env('APP_URL').'/swish/postpay')}}";
</script>

@endsection
