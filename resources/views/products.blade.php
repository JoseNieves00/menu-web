@extends('main')
@section('header')
    @include('header')
@endsection
@section('content')
<div class="slider-container">
    @csrf
    <h2>Desliza y escoge lo que mas te guste!</h2>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="slider">
                @foreach ($list_products as $item)
                <div class="box">
                    <div class="product" style="background-image: url('{{ asset('storage/files/products/'.$item->url_image) }}') "></div>
                    <p class="product-name">{{$item->name}}</p>
                    <div class="descripcion">
                        <p>{{$item->description}}</p>
                    </div>
                    <div class="buttons">
                        @if ($item->has_size==1)
                            <div class="size">
                                <button class="size-button size-s" value={{$item->price_xs}}>XS</button>
                                <button class="size-button size-m" value={{$item->price_s}}>S</button>
                                <button class="size-button size-l" value={{$item->price_m}}>M</button>
                                <button class="size-button size-xl" value={{$item->price_l}}>L</button>
                                <button class="size-button size-xl" value={{$item->price_xl}}>XL</button>
                            </div>

                            <div class="precio-box">
                                <p class="precio price_size" value="0">Seleccione un tamaño</p>
                            </div>
                        @else
                        <input type="hidden" value="{{$item->has_size}}" class="has_size">
                        <div class="precio-box price_wsize">
                            <input type="hidden" value="{{$item->price}}" class="precio_wsize">
                            <p class="precio">${{number_format($item->price,0,'.','.')}}</p>
                        </div>
                        @endif
                        <button class="button-agregar" onclick="recogidaDatos('{{$item->name}}')">Agregar al Carrito <i class="gg-shopping-cart"></i></button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="controls">
        <button class="prev" onclick="prevSlide()"><i class="gg-arrow-left-r"></i></button>

        <button class="next" onclick="nextSlide()"><i class="gg-arrow-right-r"></i></button>
    </div>
                    {{-- <div class="box">
                    <div class="pizza pizza2"></div>
                    <p class="pizza-name">Pizza 2</p>
                    <div class="descripcion">
                        <p>descripcion</p>
                    </div>
                    <div class="buttons">
                        <div class="size">
                            <button class="size-button size-s">S</button>
                            <button class="size-button size-m">M</button>
                            <button class="size-button size-l">L</button>
                            <button class="size-button size-xl">XL</button>
                        </div>
                        <div class="precio-box">
                            <p class="precio p2">Selecciona Un Tamaño</p>
                        </div>
                        <button class="button-agregar">Agregar al Carrito <i class="gg-shopping-cart"></i></button>
                    </div>
                </div>
        
                <div class="box">
                    <div class="pizza pizza3"></div>
                    <p class="pizza-name">Pizza 3</p>
                    <div class="descripcion">
                        <p>descripcion</p>
                    </div>
                    <div class="buttons">
                        <div class="size">
                            <button class="size-button size-s">S</button>
                            <button class="size-button size-m">M</button>
                            <button class="size-button size-l">L</button>
                            <button class="size-button size-xl">XL</button>
                        </div>
                        <div class="precio-box">
                            <p class="precio p3">Selecciona Un Tamaño</p>
                        </div>
                        <button class="button-agregar">Agregar al Carrito <i class="gg-shopping-cart"></i></button>
                    </div>
                </div> --}}
</div>
@endsection
@section('scripts')
    <script>

        $('.salir-carrito').hide()

        $('.carrito').click(function(){
            showCarrito()
        })

        if($('.size').css("display")=="block"){
            $('.wprice_size').hide()
        }

        $('.size-button').click(function(){
            this.className = "size-button-active"
            const nombre = $('.product-name').textContent;
            const precio = this.value
            const price_format = new Intl.NumberFormat('de-DE').format(precio)
            const tamaño = this.textContent
            $('.price_size').html('$'+price_format);
            $('.price_size').val(precio);
        })
         
        function recogidaDatos(nombre){
            const tamaño = $('.size-button-active').text()
            const price_size = $('.price_size').val()
            const has_size = $('has_size').val()
            const price_wsize = $('.precio_wsize').val()
            let price = 0

            if(has_size==1){
                price = price_size
            } else{
                price = price_wsize
            }

            
            enviarDatos(nombre,tamaño,price,$('.totalProductos'));
        }
        
        
        $('.salir-carrito').click(function(){
            hideCarrito()
        })

        const btn_enviarPedido = document.querySelectorAll(".envio-pedido")
    
        const form_datosPedido = document.querySelector(".finalizar-cont form")

        const text_transferencia = document.querySelector(".text-transf")

        $('.envio-pedido').click(function(){
                        let nombre = form_datosPedido[0].value
                        let apellido = form_datosPedido[1].value
    
                        let nombreCompleto = `${nombre} ${apellido}`
    
                        let telefono = form_datosPedido[2].value
    
                        let direccion = form_datosPedido[3].value.toLowerCase()

                        let barrio = form_datosPedido[4].value.toLowerCase()
    
                        let detalles = form_datosPedido[5].value
    
                        let radio_metodoPago = document.getElementsByName("metodoPago")
    
                        let metodoPago;
    
                        
    
                        for (let i = 0; i < radio_metodoPago.length; i++) {
                            if (radio_metodoPago[i].checked) {
                                metodoPago = radio_metodoPago[i].value
                            }
                        }
    
                        if ((nombre == "") || (apellido == "") || (direccion == "") || (barrio == "") || (telefono == "")) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Ingrese todos los Campos!',
                                iconColor: "#fa2d1e",
                                confirmButtonColor: "#fa2d1e",
                                timer: 3000
                            });
                        } else {
                            if (telefono.length != 10) {
                                console.log(telefono.length)
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Ingrese un Telefono Valido!',
                                    iconColor: "#fa2d1e",
                                    confirmButtonColor: "#fa2d1e",
                                    timer: 3000
                                });
                            } else {
                                if ((direccion.includes("cra")) || (direccion.includes("kr")) || (direccion.includes("k")) || (direccion.includes("calle")) || (direccion.includes("c")) || (direccion.includes("cll"))) {
    
                                    if (metodoPago != undefined) {
                                        // Seccion de Envio de datos despues de verificacion
                                        Swal.fire({
                                            title: "Estas Seguro de Enviar Tu pedido ?",
                                            text: "Verifica que los datos esten ingresados correctamente",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#fa2d1e",
                                            confirmButtonText: "Confirmar"
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                if (metodoPago == "transferencia") {
                                                    Swal.fire({
                                                        text: "Para despachar su pedido primero debe enviar el comprobante de pago",
                                                        icon: "info",
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                    })
                                                }
                                                enviarPedido(nombreCompleto, direccion,barrio, telefono, detalles,metodoPago)
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Escoja un Metodo de Pago',
                                            iconColor: "#fa2d1e",
                                            confirmButtonColor: "#fa2d1e",
                                            timer: 3000
                                        });
                                    }
    
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Ingrese una Direccion Valida!',
                                        iconColor: "#fa2d1e",
                                        confirmButtonColor: "#fa2d1e",
                                        timer: 3000
                                    });
                                    console.log(direccion)
                                }
                            }
                        }
        })
    </script>
@endsection