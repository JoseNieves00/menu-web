@extends('main')
@section('header')
    @include('header')
@endsection

@section('content')
@csrf
    <div class="carrito-cont">
        <h2>Carrito de compras</h2>
        <div class="productos-cont">
            <p class='text-red'>No hay Productos Agregados Al carrito</p>
        </div>
        <div class="footer-carrito">
            <div class="total-cont">
                <p class="subtotal-carrito"></p>
            </div>

            <div class="btn-cont">
                <button class="btn-finalizar">Finalizar Pedido</button>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        $('document').ready(function(){
            $('.salir-carrito').show()
            $('.carrito').hide()
        })

        $('.salir-carrito').click(function(){
            location.href = "/"
        })


    </script>
@endsection