@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
   

<div class="container">

   <div class="row">

      
         
         <div class="col-md-offset-2 col-xs-12 col-sm-12 col-md-8 pt-3 card" 
              style="background-color:#eeeeee; border:1px solid grey;  border-radiUs:10px;">
                <h2>DetalleS Orden de Pago</h2>
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
                           
                           <div class="form-group">
                             <label for="">payment_platform ocultar</label>
                             <input type="text" name="payment_platform" value="{{ $order->payment_platform_id }}">
                           </div>

                           <div class="form-group">
                             <label for="">order_id ocultar</label>
                             <input type="text" name="order_id" value="{{ $order->id }}">
                           </div>


                            <div class="text-center mt-3">
                                <button type="submit" id="payButton" class="btn btn-primary btn-lg btn-block">PAGAR AHORA CON PAYPAL</button>
                            </div>

                    <br>
                </form>

         </div>
        
   </div>

</div>



@endsection