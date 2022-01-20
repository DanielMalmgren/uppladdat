<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use HelmutSchneider\Swish\Client;
use HelmutSchneider\Swish\PaymentRequest;

class SwishController extends Controller
{
    public function test(Request $request)
    {

        $rootCert = storage_path('app/cert/Swish_TLS_RootCA.pem');
        $clientCert = [storage_path('app/cert/Swish_Merchant_TestCertificate_1234679304.pem'), 'swish'];

        $client = Client::make($rootCert, $clientCert, 'https://mss.cpc.getswish.net/swish-cpcapi/api/v1');

        $pr = new PaymentRequest([
            'callbackUrl' => env('APP_URL').'/swish/callback',
            'payeePaymentReference' => '12345',
            'payeeAlias' => '1231181189',
            'amount' => '100',
        ]);

        $id = $client->createPaymentRequest($pr);

        $data = [
            'id' => $id,
        ];

        return view('swish.test')->with($data);
    }

    public function callback(Request $request)
    {
        logger("SWISH CALLBACK!");

        $data = file_get_contents('php://input');
        $decoded = json_decode($data, $assoc = true);

        logger("Data:");
        logger(print_r($decoded, true));
    }

    public function postpay(Request $request)
    {
        $data = [
        ];

        return view('swish.postpay')->with($data);
    }
}
