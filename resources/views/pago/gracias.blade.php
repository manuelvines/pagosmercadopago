@extends('layouts.app')
@section('title', 'Confirmación de pago')
@section('content')
<div class="container">
   <div class="row">

      
         
         <div class="col-md-offset-2 col-xs-12 col-sm-12 col-md-8 pt-3 card" 
              style="background-color:#eeeeee; border:1px solid grey;  border-radiUs:10px;">
                <h2 class="alert alert-success text-center">¡RECIBIMOS SU PAGO!</h2>
                <hr>

                

                <h3>Muchas gracias por su pago de la orden: {{ $order->id }}, hemos enviado a su correo, la confirmación de su pedido.</h3>

                <p>¿Tienes dudas? Envíanos un WhatApp al 5539000734 con tu orden de pedido y correo.</p>
                


                <a href="#" class="btn btn-info">Enviar WhatApp</a>
                
                <br><br>
                <div class="division mt-3 mb-3" style="border:1px solid grey;"></div>

                <div class="mt-3 mb-3">
                          <br>
                                <a href="{{ url('/') }}" class="btn btn-info btn-bg btn-block">REGRESAR AL HOME</a>      
                                <br><br>
                </div>
                  
                
         </div>
        
   </div>

</div>


@endsection