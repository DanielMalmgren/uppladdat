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
                    Tack för din betalning!
                </div>

                <div class="card-body">

                    Nu ska det börja ladda!

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
