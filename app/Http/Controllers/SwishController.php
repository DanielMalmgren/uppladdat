<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use HelmutSchneider\Swish\Client;
use HelmutSchneider\Swish\PaymentRequest;
use HelmutSchneider\Swish\Refund;
use App\Models\Payment;
use App\Models\ChargingSession;
use Illuminate\View\View;

class SwishController extends Controller
{
    public function pay(Request $request): View|Response
    {
        $charging_session = ChargingSession::find($request->charging_session);

        if($charging_session == null) {
            return response('Missing charging session ID!', 400);
        }

        $rootCert = storage_path('app/cert/Swish_TLS_RootCA.pem');
        $clientCert = [storage_path('app/cert/Swish_Merchant_TestCertificate_1234679304.pem'), 'swish'];

        $client = Client::make($rootCert, $clientCert, 'https://mss.cpc.getswish.net/swish-cpcapi/api/v1');

        $pr = new PaymentRequest([
            'callbackUrl' => env('APP_URL').'/swish/pay/callback',
            'payeeAlias' => $charging_session->charger->owner->owner_payment_methods->where('payment_method', 'Swish')->first()->identifier,
            'amount' => $charging_session->amount,
            'message' => 'Betalning för laddning',
        ]);

        $response = $client->createPaymentRequest($pr);

        logger("Swish ID: ".$response->id);
        logger("Swish token: ".$response->paymentRequestToken);

        $payment = new Payment();
        $payment->id = $response->id;
        $payment->charging_session_id = $charging_session->id;
        $payment->payment_method = 'Swish';
        $payment->clientip = $request->ip();
        $payment->save();

        $data = [
            'applink' => "swish://paymentrequest?token=".$response->paymentRequestToken."&callbackurl=".urlencode(env('APP_URL')."/swish/postpay"),
            'charging_session_id' => $payment->charging_session_id,
        ];

        return view('swish.pay')->with($data);
    }

    public function refund(Request $request)
    {
        $payment = Payment::find($request->originalPaymentReference);

        if($request->originalPaymentReference == null) {
            return response('Missing payment reference!', 400);
        } elseif($payment == null) {
            return response('Unvalid payment reference!', 400);
        }

        $rootCert = storage_path('app/cert/Swish_TLS_RootCA.pem');
        $clientCert = [storage_path('app/cert/Swish_Merchant_TestCertificate_1234679304.pem'), 'swish'];

        $client = Client::make($rootCert, $clientCert, 'https://mss.cpc.getswish.net/swish-cpcapi/api/v1');

        $r = new Refund([
            'callbackUrl' => env('APP_URL').'/swish/refund/callback',
            'payerAlias' => $payment->charging_session->charger->owner->owner_payment_methods->where('payment_method', 'Swish')->first()->identifier,
            'amount' => strval($payment->amount),
            'originalPaymentReference' => $request->originalPaymentReference,
        ]);

        $response = $client->createRefund($r);

        logger("Swish refund response: ".$response);
    }

    public function refund_callback(Request $request): void
    {
        $data = file_get_contents('php://input');
        $decoded = json_decode($data, $assoc = true);

        logger("Swish refund callback from ".$request->ip().". Content:".$data);

        $payment = Payment::find($decoded['originalPaymentReference']);
        $payment->status = $decoded['status'];
        $payment->save();
    }
   
    public function pay_callback(Request $request): void
    {
        $data = file_get_contents('php://input');
        $decoded = json_decode($data, $assoc = true);

        logger("Swish pay callback from ".$request->ip().". Content:".$data);

        $payment = Payment::find($decoded['id']);
        $payment->status = $decoded['status'];
        $payment->payerAlias = $decoded['payerAlias'];
        $payment->payeeAlias = $decoded['payeeAlias'];
        $payment->currency = $decoded['currency'];
        $payment->amount = $decoded['amount'];
        $payment->save();

        if($payment->charging_session_id !== null) {
            $payment->charging_session->status = $decoded['status'];
            $payment->charging_session->save();
            //TODO: Påbörja själva laddningen här!
        }
    }
}
