@extends('main')
@section('header')
    @include('header')
@endsection
@section('content')
        {{-- <div class="filter"></div>
        <div class="popup-cont">
            <button class="salir-carrito">
                <i class="gg-close"></i>
            </button>
            <div class="product-details"></div>
        </div> --}}


        <div class="row w-75 mt-4" style="min-height: 90vh">
            <div class="col-sm-12 col-md-12 col-ld-6 p-0 d-flex flex-column gap-5">

                <div class="row">
                    <h2 class="m-0 p-0 text-center">Bienvenido a Pizza Station!</h2>
                </div>

                @foreach ($list_category as $item)
                <div class="row">
                    <div class="categorias-cont p-0">
                        <button class="btn w-100 p-2 fs-4 text text-capitalize" style="background-color: #fa2d1e;color:white" onclick="location.href='{{ route('getCategoryProducts', $item->name)}}'">{{$item->name}}</button>
                    </div>
                </div>
                @endforeach
            </div>
@endsection
@section('scripts')
    <script>
        $('.salir-carrito').hide()

        $('.carrito').click(function(){
            showCarrito()
        })

        $('.salir-carrito').click(function(){
            hideCarrito()
        })
    </script>
@endsection
