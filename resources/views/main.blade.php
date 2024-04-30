<?php

header("Access-Control_Allow_Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Content-type:application/json;charset=utf-8"); 
header("Access-Control-Allow-Methods: GET");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzería Slider</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <!-- css.gg -->
    <link href="https://css.gg/css" rel="stylesheet" />

    <!-- UNPKG -->
    <link href="https://unpkg.com/css.gg/icons/icons.css" rel="stylesheet" />

    <!-- JSDelivr -->
    <link href="https://cdn.jsdelivr.net/npm/css.gg/icons/icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <header>
        @yield('header')
    </header>

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
    
    <div class="contenedor">        
        @yield('content')
    </div>

    <footer class="d-flex justify-content-center mt-2">
        <p class="text-footer" style="color: lightgray; font-size:14px">© Pizza Station - 2024</p>
    </footer>


    <script
    src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
    crossorigin="anonymous"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>
    @yield('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>