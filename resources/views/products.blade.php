@extends('main')
@section('header')
    @include('header')
@endsection
@section('content')
<div class="slider-container mt-4">
    @csrf
    <h2>Desliza y escoge lo que mas te guste!</h2>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <div class="slider">
                @foreach ($list_products as $item)
                <div class="box">
                    <div class="product" style="background-image: url('{{ $item->url_image!=null ? asset('storage/files/products/'.$item->url_image) : asset('assets/img/logo.png')}}') "></div>
                    <p class="product-name">{{$item->name}}</p>
                    <div class="descripcion">
                        <p>{{$item->description}}</p>
                    </div>
                    <div class="buttons">
                        <input type="hidden" value="{{$item->category->has_size}}" name="has_size">
                        @if ($item->category->has_size==1)
                            <div class="size">
                                @if ($item->price_xs!=null)
                                    <button class="size-button size-xs" value={{$item->price_xs}}>XS</button>
                                @endif

                                @if ($item->price_s!=null)
                                    <button class="size-button size-s" value={{$item->price_s}}>S</button>
                                @endif

                                @if ($item->price_m!=null)
                                    <button class="size-button size-m" value={{$item->price_m}}>M</button>
                                @endif

                                @if ($item->price_l!=null)
                                    <button class="size-button size-l" value={{$item->price_l}}>L</button>
                                @endif

                                @if ($item->price_m!=null)
                                    <button class="size-button size-xl" value={{$item->price_xl}}>XL</button>
                                @endif
                            </div>

                            <div class="precio-box">
                                <p class="precio price_size" value="0">Seleccione un tamaño</p>
                            </div>
                        @else
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
        <button class="prev carousel-control" onclick="prevSlide()"><i class="gg-arrow-left-r"></i></button>

        <button class="next carousel-control" onclick="nextSlide()"><i class="gg-arrow-right-r"></i></button>
</div>
@endsection
@section('scripts')
    <script>

    let startX = 0;
    let isDragging = false;

    slider.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
    });

    slider.addEventListener('touchmove', (e) => {
        if (isDragging) {
            const currentX = e.touches[0].clientX;
            const diffX = startX - currentX;
            if ((diffX > 12) || (diffX < -12)) {
                if (diffX > 12) {
                    nextSlide();
                } else if (diffX < 12) {
                    prevSlide();
                }
            }
            isDragging = false;
        }
    });
    
    slider.addEventListener('touchend', () => {
        isDragging = false;
    });

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
            const has_size = $('input[name=has_size]')[0].value
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


    </script>
@endsection