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
                    <a href="{{$applink}}">
                        {!! QrCode::size(300)->generate($applink); !!}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){
        window.location = "{{$applink}}";
    });

    $(function() {
        polls = 0;

        function poll() {
            $.ajax({
                url: '/gc/checkstatus/{{$charging_session_id}}',
                dataType:"text",
                type: 'GET',
                success: function(data) {
                    polls++;
                    console.log(polls);
                    if(data=='PAID') {
                        window.location = "/gc/success?charging_session_id={{$charging_session_id}}";
                    }
                    if(polls>180 || data=='DECLINED'|| data=='ERROR' || data=='CANCELLED') {
                        window.location = "/gc/failure";
                    }
                    setTimeout(poll,1000);
                },
                error: function() {
                    console.log("ERROR");
                }
            });
        }

        poll();
    });
</script>

@endsection
