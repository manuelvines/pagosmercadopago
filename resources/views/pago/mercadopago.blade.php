@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
   

<div class="container">

   <div class="row">

      
         
         <div class="col-md-offset-2 col-xs-12 col-sm-12 col-md-8 pt-3 card" 
              style="background-color:#eeeeee; border:1px solid grey;  border-radiUs:10px;">
                <h2>Detalle Orden de Pago</h2>
                <hr>
                <h5>Workshop: {{  $workshop->name }}</h5>
                <h5>Precio: ${{  $order->amount }}  
                   
                       @if($order->payment_platform_id == 1)
                        USD
                       @endif  

                       @if($order->payment_platform_id == 2)
                        MXN
                       @endif  
                    
                </h5>
                <h5>Folio: {{ $order->id }} </h5>
                <h5>Asistente: {{ $order->name }}</h5> 

                <div class="division mt-3 mb-3" style="border:1px solid grey;"></div>
                <p>Llena el siguiente formulario para completar tu orden.</p>
                 <hr>      
                 <div class="text-center mt-3">
                                   <img src="{{  asset('images/pagar-seguro.png') }}" alt="Pagos seguros" class="img-fluid">

                 </div>     


                 <form action="{{ route('pay')  }}" method="POST" id="paymentForm" class="mt-3">
                 @csrf


                  

                   <h6 class="mt-3">Detalles de la tarjeta:</h6>

                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                 
                                  @php //id de la plataforma de pago @endphp
                                  <label for="">Plataforma de pago, borrar y poner como hidden</label>
                                  <input type="text" class="form-control" name="payment_platform" value="{{  $order->payment_platform_id  }}">
                                 
                                  @php //id del order @endphp
                                  <label for="">ID order, borrar y poner como hidden</label>

                                  <input type="text" class="form-control" name="order_id" value="{{  $order->id  }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <label for="">Nombre en la tarjeta</label>
                                    <input class="form-control" type="text" data-checkout="cardholderName" placeholder="Your Name">
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-6">
                                    <label for="">Correo del propietario</label>
                                    <input class="form-control" type="email" data-checkout="cardholderEmail" placeholder="email@example.com" name="email">
                                </div>
                            </div>
                            
                            
                        <div class="row">
                                <div class="col-md-12">
                                   <label for="">16 digitos de la tarjeta sin espacios</label>

                                    <input class="form-control" type="text" id="cardNumber" data-checkout="cardNumber" placeholder="Card Number">
                                </div>
                            </div>    


                            <div class="row">
                            
                                <div class="col-md-4">
                                    <label for="">Mes de expiración (MM)</label>
                                    <input class="form-control" type="text" data-checkout="cardExpirationMonth" placeholder="MM">
                                </div>
                                <div class="col-md-4">
                                    <label for="">Año de expiración (YY)</label>

                                    <input class="form-control" type="text" data-checkout="cardExpirationYear" placeholder="YY">
                                </div>
                                <div class="col-md-4">
                                   <label for="">Código de seguridad</label>

                                    <input class="form-control" type="text" data-checkout="securityCode" placeholder="CVC">
                                </div>

                            </div>


                            <div class="form-group form-row">
                                <div class="col-2">
                                    <select class="custom-select" data-checkout="docType"></select>
                                </div>
                                <div class="col-3">
                                    <input class="form-control" type="text" data-checkout="docNumber" placeholder="Document">
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <div class="col">
                                    <small class="form-text text-success"  role="alert" >Su pago es procesado de forma segura por Mercado Pago & Security SSL Encrypt</small>
                                </div>
                            </div>

                            <div class="form-group form-row">
                                <div class="col">
                                    <small class="form-text text-danger" id="paymentErrors" role="alert"></small>
                                </div>
                            </div>

                            <input type="hidden" id="cardNetwork" name="card_network">
                            <input type="hidden" id="cardToken" name="card_token">

                             <div class="text-center mt-3">
                                <button type="submit" id="payButton" class="btn btn-primary btn-lg btn-block">PAGAR AHORA</button>
                            </div>

                    <br>
                </form>

         </div>
        
   </div>

</div>


@push('scripts')
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

    <script>
        const mercadoPago = window.Mercadopago;
        mercadoPago.setPublishableKey('{{ config('services.mercadopago.key') }}');
        mercadoPago.getIdentificationTypes();
    </script>

    <script>
        function setCardNetwork()
        {
            const cardNumber = document.getElementById("cardNumber");
            mercadoPago.getPaymentMethod(
                { "bin": cardNumber.value.substring(0,6) },
                function(status, response) {
                    const cardNetwork = document.getElementById("cardNetwork");
                    cardNetwork.value = response[0].id;
                }
            );
        }
    </script>


    <script>
        const mercadoPagoForm = document.getElementById("paymentForm");
        mercadoPagoForm.addEventListener('submit', function(e) {
         
                e.preventDefault();
                mercadoPago.createToken(mercadoPagoForm, function(status, response) {
                    if (status != 200 && status != 201) {
                        const errors = document.getElementById("paymentErrors");

                        //muestra solo el primer error
                        errors.textContent = response.cause[0].description;
                    } else {
                        const cardToken = document.getElementById("cardToken");
                       
                        setCardNetwork();
                       
                        cardToken.value = response.id;
                        
                        mercadoPagoForm.submit();
                
                    }
                });
           
        });
    </script>
   
@endpush


@endsection