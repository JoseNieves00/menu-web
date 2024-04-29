@extends('main')
@section('header')
    @include('header')
@endsection
@section('content')
<div class="slider-container">

    <h2>Desliza y escoge la que mas te guste!</h2>

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
                        {{-- <div class="size">
                            <button class="size-button size-s">S</button>
                            <button class="size-button size-m">M</button>
                            <button class="size-button size-l">L</button>
                            <button class="size-button size-xl">XL</button>
                        </div> --}}
                        <div class="precio-box">
                            <p class="precio p1">${{number_format($item->price,0,'.','.')}}</p>
                        </div>
                        <button class="button-agregar">Agregar al Carrito <i class="gg-shopping-cart"></i></button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="controls">
        <button class="prev"><i class="gg-arrow-left-r" onclick="prevSlide()"></i></button>

        <button class="next"><i class="gg-arrow-right-r" onclick="nextSlide()"></i></button>
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
    $('.salir-carrito').show()
    $('.carrito').hide()
    goCarrito()
})
    </script>
@endsection