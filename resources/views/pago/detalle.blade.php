@extends('layouts.app')
@section('title', 'Page Title')
@section('content')
<div class="container">
   <div class="row">

      
         
         <div class="col-md-offset-2 col-xs-12 col-sm-12 col-md-8 pt-3 card" 
              style="background-color:#eeeeee; border:1px solid grey;  border-radiUs:10px;">
                <h2>Detalles del Evento</h2>
                <hr>
                <h5>Workshop: {{  $workshop->name }}</h5>

                @if( $payment_platform_id->id == 1 )
                  <h5>Precio: ${{  $precios->preciousd }} USD</h5>
                @endif
               
                @if( $payment_platform_id->id == 2 )
                 <h5>Precio: ${{  $precios->preciomx }} MXN</h5>
                @endif
              

               
               
                <div class="division mt-3 mb-3" style="border:1px solid grey;"></div>

                <h5 class="text-center">¿Estás interesado en asistir a este WorkShop?</h5>
                <p>Llena el siguiente formulario para completar tu registro.</p>


                <form action="{{ route('createorder') }}" method="POST" style="margin-top:20px;">

                   @csrf
                   
                   <div class="form-group">
                        <label for="nombre"><span class="text-danger">*</span>Ingrese  nombre completo:</label>
                        <input class="form-control" type="text" name="name" id="name" required>
                   </div> 
                   <div class="form-group">
                        <label for="nombre"><span class="text-danger">*</span> Ingrese email:</label>
                        <input class="form-control" type="email" name="email" id="email" required>
                   </div> 

                   <div class="form-group">
                        <label for="nombre"><span class="text-danger">*</span> Ingrese su teléfono:</label>
                        <input class="form-control" type="text" name="phone" id="phone" required>
                   </div> 

                   <div class="form-group">
                        <input class="form-control" type="text" value="{{ $workshop->workshop_id }}" name="workshop_id" id="workshop_id" required>
                   </div> 
                     
                     
                   @if( $payment_platform_id->id == 1 )
                    @php /*pagara en dolares por paypal*/ @endphp
                   <div class="form-group">
                       <input type="text" name="payment_platform_id" value="{{ $payment_platform_id->id }}" >
                   </div> 
                   <div class="form-group">
                       <input type="text" name="amount" value="{{ $precios->preciousd }}" >
                   </div> 
                   @endif

                   @if( $payment_platform_id->id == 2 )
                     @php /*pagara en pesos por mercadopago*/ @endphp
                   <div class="form-group">
                       <input type="text" name="payment_platform_id" value="{{ $payment_platform_id->id }}" >
                   </div> 
                   <div class="form-group">
                       <input type="text" name="amount" value="{{ $precios->preciomx }}" >
                   </div> 
                   @endif

 


                
                   <input type="submit" value="PROCEDER A PAGAR" class="btn btn-success btn-lg btn-block mt-3 mb-3" style="color:white;">
                   <hr>
                   <span class="text-danger">*</span> Estos valores son obligatorios
                </form>

         </div>
        
   </div>

</div>


@endsection