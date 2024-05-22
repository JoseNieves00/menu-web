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
                        {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_create_topping')) !!}
                            <input type="hidden" id="id_product" name="id_product"  value="{{$item->id}}">
                            <input type="hidden" id="price" name="price"  value="">
                            <input type="hidden" id="versionName" name="versionName"  value="">
                            @csrf
                        <select name="select-versions custom-select" id="select-versions">
                            <option value="0">Seleccione una version</option>
                            @foreach ($list_version as $item2)
                            <option id="versionsOpt" value="{{$item2->price}}">{{$item2->name}}</option>
                            @endforeach
                        </select>
                        {!! Form::close() !!}
                        <div class="precio-box">
                            <p class="precio"></p>
                        </div>
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

    const precio = document.querySelector('#price')
    const versionName = document.querySelector('#versionName')

    const selects = document.querySelectorAll('#select-versions');

selects.forEach(select => {
    select.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const versionName = selectedOption.textContent;
        const versionPrice = selectedOption.value;
        const precio = document.querySelector('.precio-box .precio');
        const precio_inpt = document.querySelector('#price');
        const versionName_inpt = document.querySelector('#versionName');

        
        const precioFormat = new Intl.NumberFormat('de-DE').format(versionPrice);
        if(precioFormat>0){
            precio.textContent = "$" + precioFormat;
            nombreVersion = versionName
            versionName_inpt.value = versionName
            precio_inpt.value = versionPrice
            console.log(versionName_inpt.value,precio_inpt.value)
        } else {
            precio.textContent = ""
        }
    });
});

    let currentIndex = 0;

function nextSlide() {
    currentIndex = (currentIndex + 1) % boxes.length;
    showSlide(currentIndex);
    limpiarSelects()
    limpiarPrecios()
    cleanButton()
    // resetPrice()
}

function prevSlide() {
    currentIndex = (currentIndex - 1 + boxes.length) % boxes.length;
    showSlide(currentIndex);
    limpiarSelects()
    limpiarPrecios()
    cleanButton()
    // resetPrice()
}

function limpiarSelects() {
    const selects = document.querySelectorAll("#select-versions");
    selects.forEach(item => {
        item.value = '0'; 
    });
    versionName.value= ""
    precio.value = ""
}

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
        
        function recogidaDatos(nombre){
            enviarDatos(versionName.value,precio.value,nombre);
        }

        // function getToppings(){            
        //     const nombre = $('#versionsOpt').text();
        //     const id_version = $('#versionsOpt').val()
        //     let url_post = "{{config('global.server')}}/getToppings/"+id_version;
        //     let token = $('input[name=_token]')[0].value


        //     let request = {
        //         "_token":token,
        //         "name":nombre,
        //         "id_version": id_version,
        //     }

        //     $.post(url_post,request,(response)=>{
        //         if(!response.error){
        //             console.log(response)
        //         } else {
        //             toastr.error(response.message)
        //             return
        //         }
        //     })

        //     enviarDatos(nombre,tamaño,precio);
        // }
        
        
        $('.salir-carrito').click(function(){
            hideCarrito()
        })


    </script>
@endsection