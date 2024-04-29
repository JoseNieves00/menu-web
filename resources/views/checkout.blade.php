@extends('main')
@section('content')
        <div class="finalizar-cont">
            <div class="text-title">
                <h2>Finalizar Pedido</h2>
                <h3>Ingresa los siguientes datos:</h3>
            </div>

            <form action="#">
                <label for="name">Ingresa tu nombre: <span>*</span></label>
                <input type="text" class="name-inpt">
                <label for="lastname">Ingresa tu Apellido: <span>*</span></label>
                <input type="text" class="lastname-inpt">
                <label for="phone-number">Ingresa tu Telefono: <span>*</span></label>
                <input type="text" class="phoneNumer-inpt">
                <label for="ubicacion">Ingresa tu Direccion: <span>*</span></label>
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
            <button class="envio-pedido">Enviar</button>
        </div>
@endsection
@section('scripts')
    <script>
    </script>
@endsection