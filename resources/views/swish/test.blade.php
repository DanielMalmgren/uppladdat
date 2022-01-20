@extends('layouts.app')

@section('content')

<script type="text/javascript">
    window.location = "swish://paymentrequest?token={{$id}}&callbackurl={{urlencode(env('APP_URL').'/swish/postpay')}}";
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    Skickar Swish-förfrågan!
                </div>

                <div class="card-body">

                    Om allt fungerar borde du nu få upp Swish-appen i din telefon.

                    ID: {{$id}}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
