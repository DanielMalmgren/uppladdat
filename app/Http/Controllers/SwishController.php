<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use HelmutSchneider\Swish\Client;
use HelmutSchneider\Swish\PaymentRequest;
use App\Models\Payment;
use App\Models\ChargingSession;

class SwishController extends Controller
{
    public function pay(Request $request)
    {
        //$charging_session = ChargingSession::find($request->charging_session);

        $rootCert = storage_path('app/cert/Swish_TLS_RootCA.pem');
        $clientCert = [storage_path('app/cert/Swish_Merchant_TestCertificate_1234679304.pem'), 'swish'];

        $client = Client::make($rootCert, $clientCert, 'https://mss.cpc.getswish.net/swish-cpcapi/api/v1');

        $pr = new PaymentRequest([
            'callbackUrl' => env('APP_URL').'/swish/callback',
            'payeeAlias' => '1231181189',
            'amount' => '100',
            'message' => 'Betalning för laddning',
        ]);

        //Using a not merged PR in swish-php to get the PaymentRequestToken
        //See https://github.com/helmutschneider/swish-php/pull/20
        $response = $client->createPaymentRequest($pr);

        logger("Swish ID: ".$response->id);
        logger("Swish token: ".$response->paymentRequestToken);

        $payment = new Payment();
        $payment->id = $response->id;
        $payment->charging_session_id = $request->charging_session;
        $payment->payment_method = 'Swish';
        $payment->save();

        $data = [
            'applink' => "swish://paymentrequest?token=".$response->paymentRequestToken."&callbackurl=".urlencode(env('APP_URL')."/swish/postpay"),
            'charging_session_id' => $payment->charging_session_id,
        ];

        return view('swish.pay')->with($data);
    }

    public function callback(Request $request)
    {
        $data = file_get_contents('php://input');
        $decoded = json_decode($data, $assoc = true);

        $payment = Payment::find($decoded['id']);
        $payment->status = $decoded['status'];
        $payment->payerAlias = $decoded['payerAlias'];
        $payment->payeeAlias = $decoded['payeeAlias'];
        $payment->currency = $decoded['currency'];
        $payment->amount = $decoded['amount'];
        $payment->save();

        if($payment->charging_session !== null) {
            $payment->charging_session->status = $payment->status;
            //TODO: Påbörja själva laddningen här!
        }

    }
}
