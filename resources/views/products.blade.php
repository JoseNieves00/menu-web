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
                                <p class="precio price_size">Seleccione un tamaño</p>
                            </div>
                        @else
                        <div class="precio-box wprice_size">
                            <p class="precio_size precio">${{number_format($item->price,0,'.','.')}}</p>
                        </div>
                        @endif
                        <button class="button-agregar">Agregar al Carrito <i class="gg-shopping-cart"></i></button>
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
            let precio = this.value
            let price_format = new Intl.NumberFormat('de-DE').format(precio)
            let tamaño = this.textContent
            $('.price_size').html('$'+price_format);
        })

        
        
        $('.salir-carrito').click(function(){
            hideCarrito()
        })
    </script>
@endsection