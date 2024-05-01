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
    <link rel="stylesheet" href="{{ asset('css/toast.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
</head>

<body>

    <header>
        @yield('header')
    </header>

    <div class="carrito-cont">
        <h2>Carrito de compras</h2>
        <p class='text-red'>No hay Productos Agregados Al carrito</p>
        <div class="productos-cont">
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

    <div class="finalizar-cont">
        <div class="text-title">
            <h2>Finalizar Pedido</h2>
            <h3>Ingresa los siguientes datos:</h3>
        </div>

        <form action="#">
            <label for="name">Nombre: <span>*</span></label>
            <input type="text" class="name-inpt">
            <label for="lastname">Apellido: <span>*</span></label>
            <input type="text" class="lastname-inpt">
            <label for="phone-number">Telefono: <span>*</span></label>
            <input type="text" class="phoneNumer-inpt">
            <label for="direcion-inpt">Direccion: <span>*</span></label>
            <input type="text" class="direccion-inpt">
            <label for="ubicacion">Barrio: <span>*</span></label>
            <input type="text" class="direccion-inpt">
            <label for="observacion-inpt">Detalle: </label>
            <textarea class="observacion-inpt" cols="30" rows="10"
                placeholder="Casa / Apartamento / Etc"></textarea>
            <label for="metodoPago">Metodo de Pago <span>*</span></label>
            <div style="display: flex;width: 100%;justify-content: space-around;">
                <div class="efectivo-cont"
                    style="display: flex;flex-direction: column;align-items: center;gap: 10px;">
                    <label for="efectivo">Efectivo:</label>
                    <input type="radio" value="efectivo" name="metodoPago" class="radioInputs radioEfectivo">
                </div>

                <div class="transferencia-cont"
                    style="display: flex;flex-direction: column;align-items: center;gap: 10px;">
                    <label for="efectivo">Transferencia:</label>
                    <input type="radio" value="transferencia" name="metodoPago" class="radioInputs radioTransf">
                </div>
            </div>
        </form>
        <button class="envio-pedido" onclick="datosUsuario()">Enviar</button>
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
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/toast.js') }}"></script>
</body>

</html>