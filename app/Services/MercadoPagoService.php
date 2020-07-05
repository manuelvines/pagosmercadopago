<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\ConsumesExternalServices;
use App\Services\CurrencyConversionService;
use DB;

class MercadoPagoService
{
    use ConsumesExternalServices;

    protected $baseUri;

    protected $key;

    protected $secret;

    protected $baseCurrency;

    protected $converter;


   // public function __construct(CurrencyConversionService $converter)
    public function __construct()
    {
        $this->baseUri = config('services.mercadopago.base_uri');
        $this->key = config('services.mercadopago.key');
        $this->secret = config('services.mercadopago.secret');
        $this->baseCurrency = config('services.mercadopago.base_currency');

       // $this->converter = $converter;
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $queryParams['access_token'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {
        return $this->secret;
    }

    public function handlePayment(Request $request)
    {
        $request->validate([
            'card_network' => 'required',
            'card_token' => 'required',
            'email' => 'required',
            'order_id' => ['required','numeric','exists:orders,id']
        ]);

        /**Extraemos la orden de la table orders */  
        $order = DB::table('orders')
        ->where('orders.id', $request->order_id)
        ->first();

        $payment = $this->createPayment(
            $order->amount,
            $request->card_network,
            $request->card_token,
            $request->email
        );

        if ($payment->status === "approved") {
            
            $name = $payment->payer->first_name; 
            //$amount = number_format($payment->transaction_amount, 0, ',', '.');
            /**ACTUALIZAR EL STATUS DE ORDER 1 pago*/

            $orderActualizar = DB::table('orders')
            ->where('orders.id', $request->order_id)
            ->update(['status' => 1]);

            return redirect()->route('gracias', ['id' =>  $order->id ]);


        }

            /**ACTUALIZAR EL STATUS DE ORDER 2 rechazado*/
            $orderActualizar = DB::table('orders')
            ->where('orders.id', $request->order_id)
            ->update(['status' => 2]);
            /**ACTUALIZAR EL STATUS DE ORDER */

            return "pago rechazado";
        
    }

    public function handleApproval()
    {
        //
    }

    public function createPayment($value, $cardNetwork, $cardToken, $email, $installments = 1)
    {
        return $this->makeRequest(
            'POST',
            '/v1/payments',
            [],
            [
                'payer' => [
                    'email' => $email,
                ],
                'binary_mode' => true,
                //'transaction_amount' => round($value * $this->resolveFactor($currency)),
                'transaction_amount' => round($value),
                'payment_method_id' => $cardNetwork,
                'token' => $cardToken,
                'installments' => $installments,
                'statement_descriptor' => config('app.name'),
            ],
            [],
            $isJsonRequest = true
        );


    }

    public function resolveFactor($currency)
    {
        return $this->converter
            ->convertCurrency($currency, $this->baseCurrency);
    }
}
