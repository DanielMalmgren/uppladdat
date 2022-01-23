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

                    Om allt fungerar borde du nu få upp Swish-appen i din telefon.<br><br>

                    Annars får du använda QR-koden istället:<br>
                    <a href="swish://paymentrequest?token={{$token}}&callbackurl={{urlencode(env('APP_URL').'/swish/postpay')}}">
                        {!! QrCode::size(250)->generate("swish://paymentrequest?token=".$token."&callbackurl=".urlencode(env('APP_URL').'/swish/postpay')); !!}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){
        window.location = "swish://paymentrequest?token={{$id}}&callbackurl={{urlencode(env('APP_URL').'/swish/postpay')}}";
    });
</script>

@endsection
