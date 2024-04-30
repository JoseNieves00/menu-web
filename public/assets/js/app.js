const boxes = document.querySelectorAll('.box');
const slider = document.querySelector('.slider');
const carrito = document.querySelector('.carrito-cont');
const contenedor = document.querySelector('.contenedor');
const footer_carrito = document.querySelector('.footer-carrito');
const sizeButtons = document.querySelectorAll('.size button');
const precio_size = document.querySelectorAll(".precio-box .price_size")
const totalProductos = document.querySelector(".totalProductos")
const carrito_cont = document.querySelector(".carrito-cont")
const finalizar_cont = document.querySelector(".finalizar-cont")

$(totalProductos).hide()

$(finalizar_cont).hide()

$(carrito).hide()

function limpiarPrecios(){
    precio_size.forEach(precio => {
        precio.innerHTML = "Selecciona Un Tamaño";
    });
}

sizeButtons.forEach(button => {
    button.addEventListener('click', () => {
        cleanButton()
    });
});

function cleanButton() {
    sizeButtons.forEach(buttons => {
        buttons.className = "size-button"
})
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

let pedido = {
    productos: [], // Aquí se almacenarán los productos agregados al pedido
    total: 0,// Aquí se almacenará el total del pedido
    totalProductos: 0,
};

function showCarrito(){
    $('.salir-carrito').show()
    $('.carrito').hide()
    $(contenedor).hide()
    $(carrito).show()

    if(pedido.totalProductos==0){
        $(footer_carrito).hide()
    }

    mostrarPedido()
}

function hideCarrito(){
    $('.salir-carrito').hide()
    $('.carrito').show()
    $(contenedor).show()
    $(carrito).hide()
    finalizar_cont.style.display = "none"
}

function getProducts(){
    let url = "{{ config('global.server') }}/get_response_search"
    $.post(url, (response) => {
        if(response.error){
            toastr.error(response.message)
            return
        }else{
            response.list.forEach((item) => {
                console.log(item)
        })
        }
    })
}

    let currentIndex = 0;
    let startX = 0;
    let isDragging = false;

    function nextSlide() {
        currentIndex = (currentIndex + 1) % boxes.length;
        showSlide(currentIndex);
        limpiarPrecios()
        cleanButton()
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + boxes.length) % boxes.length;
        showSlide(currentIndex);
        limpiarPrecios()
        cleanButton()    
    }

    function scrollUp(){
        window.scrollTo({
            top: 0, behavior:'smooth'
        });
    }

    function rotatePizza(index) {
        boxes.forEach((box, i) => {
            if (i === index) {
                box.querySelector('.product').style.transform = 'rotate(360deg)';
            } else {
                box.querySelector('.product').style.transform = 'none';
            }
        });
    }

    function showSlide(index) {
        slider.style.transform = `translateX(-${index * 100}%)`;
        rotatePizza(index);
        scrollUp()
        // limpiarPrecios();
    }

    function enviarDatos(nombreProduct,sizeProduct,precioProduct) {
            let cantidadInput = 1;
            console.log(cantidadInput)
            if (precioProduct != undefined) {
                Swal.fire({
                    title: `${nombreProduct.toUpperCase()}`,
                    html:
                        `<p>Ingresar Cantidad</p>` +
                        `<div class="input-group" style="display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 2%;">` +
                        `<span class="input-group-btn">` +
                        `<button type="button" class="btn btn-danger btn-number-minus boton-cantidad" data-type="minus" data-field="cantidad">` +
                        `<span class="glyphicon glyphicon-minus">-</span>` +
                        `</button>` +
                        `</span>` +
                        `<input type="text" id="cantidad" name="cantidad" class="form-control input-number" value="1" min="1" max="10" readonly onpaste="return false;" style="padding: 5px 9px;border: 1px solid red;border-radius: 3px;text-align: center;">` +
                        `<span class="input-group-btn">` +
                        `<button type="button" class="btn btn-success btn-number-plus boton-cantidad" data-type="plus" data-field="cantidad"` +
                        `<span class="glyphicon glyphicon-plus">+</span>` +
                        `</button>` +
                        `</span>` +
                        `</div>`,
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    confirmButtonColor: "#fa2d1e",
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        const cantidad = document.getElementById('cantidad').value;
                        return cantidad;
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        const cantidadProduct = result.value;
                        console.log("Cantidad seleccionada:", cantidadProduct);
                        if(sizeProduct!=undefined){
                            confirmar(precioProduct, cantidadProduct, nombreProduct, sizeProduct);
                        }else{
                            confirmar(precioProduct, cantidadProduct, nombreProduct);
                        }
                        limpiarPrecios()
                        cleanButton()
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        limpiarPrecios()
                        cleanButton()
                    }
                });
                const inputCantidad = document.getElementById('cantidad');
    
                document.querySelector(".btn-number-minus").addEventListener("click", () => {
                    let cantidad = parseInt(inputCantidad.value);
                    if (cantidad > parseInt(inputCantidad.min)) {
                        cantidad--;
                        inputCantidad.value = cantidad;
                    }
                });
                document.querySelector(".btn-number-plus").addEventListener("click", () => {
                    let cantidad = parseInt(inputCantidad.value);
                    console.log(cantidad)
                    console.log(cantidad)
                    if (cantidad < parseInt(inputCantidad.max)) {
                        cantidad++;
                        inputCantidad.value = cantidad;
                    }
                });
    
    
                // Botones de incremento y decremento
            }
        }

        function confirmar(precio, cantidad, nombre, tamaño) {


                Swal.fire({
                    icon: "success",
                    title: "Agregado!",
                    text: "Producto Agregado Al Carrito",
                    showConfirmButton: false,
                    timer: 1500
                });
        
                let totalProducto = precio * cantidad
                // Verificar si ya hay una pizza con el mismo nombre y tamaño en el pedido
                if(tamaño){
                    let productoExistente = pedido.productos.findIndex(producto => producto.name === nombre && producto.size === tamaño);
                    if (productoExistente !== -1) {
                        pedido.productos[productoExistente].cantidad+=parseInt(cantidad);
                        pedido.productos[productoExistente].precio += parseInt(precio);
                    } else {
                        pedido.productos.push({ name: nombre, size: tamaño, cantidad: parseInt(cantidad), precio: parseInt(precio) });
                        pedido.totalProductos += 1
                        actualizarNProductos()
                    }

                    console.log("Producto agregado al pedido:", nombre, "Tamaño:", tamaño, "Cantidad:", cantidad);
                } else {
                    let productoExistente = pedido.productos.findIndex(producto => producto.name === nombre);
                    if (productoExistente !== -1) {
                        pedido.productos[productoExistente].cantidad+=parseInt(cantidad);
                        pedido.productos[productoExistente].precio += parseInt(precio);
                    } else {
                        pedido.productos.push({ name: nombre, cantidad: parseInt(cantidad), precio: parseInt(precio) });
                        pedido.totalProductos += 1
                        actualizarNProductos()
                    }
                    console.log("Producto agregado al pedido:", nombre, "Cantidad:", cantidad);
                }
                pedido.total += totalProducto
        
        
                console.log("Total del pedido:", pedido.total);
                console.log("Total productos:", pedido.totalProductos);
            }

    function actualizarNProductos() {
        if (pedido.totalProductos > 0) {
            totalProductos.style.display = "flex"
            totalProductos.textContent = pedido.totalProductos
        } else {
            totalProductos.style.display = "none"
        }
    }

    function mostrarPedido() {
            console.log(pedido)
            limpiarPrecios()
            cleanButton()
    
            productos_cont = carrito_cont.querySelector(".productos-cont")
            productos_cont.innerHTML = "";
    
            if (pedido.productos != "") {
                productos_cont.innerHTML = ""
                footer_carrito.style.display = "flex"
                pedido.productos.forEach(productos => {
                    console.log(productos)
                    const box_produdct = document.createElement('div')
                    box_produdct.className = "box-product"
                    productos_cont.appendChild(box_produdct)
    
                    const product_details = document.createElement('div')
                    product_details.className = "product-details"
                    box_produdct.appendChild(product_details)
    
                    const product_info = document.createElement('div')
                    product_info.className = "product-info"
                    product_details.appendChild(product_info)
    
                    const name_product = document.createElement('p')
                    name_product.textContent = `${productos.cantidad}X ${productos.name} ${productos.size==undefined ? '' : productos.size}`
                    name_product.className = "product-name m-0"
                    product_info.appendChild(name_product)
    
                    const product_price = document.createElement('div')
                    product_info.appendChild(product_price)
    
                    const price_product = document.createElement('p');
                    price_product.className = "product-price m-0"
                    let precioFormat = new Intl.NumberFormat('de-DE').format(productos.precio)
                    price_product.textContent = `$${precioFormat}`;
                    product_price.appendChild(price_product);
    
                    const product_btns = document.createElement('div')
                    product_btns.className = "product-btns"
                    product_details.appendChild(product_btns)
    
                    const btn_eliminar = document.createElement('button')
                    btn_eliminar.className = "btn-eliminar"
                    btn_eliminar.innerHTML = "<i class='gg-trash'></i>"
                    product_btns.appendChild(btn_eliminar)
    
                    product_btns.querySelector(".btn-eliminar").addEventListener("click", () => {
                        const productName = productos.name;
                        const productSize = productos.size;
    
                        Swal.fire({
                            title: "Estas Seguro De eliminar Este Producto?",
                            text: "Se eliminara de tu carrito",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#fa2d1e",
                            confirmButtonText: "Eliminar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Eliminado!",
                                    text: "El producto ha sido eliminado de forma Exitosa",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: "1200"
                                });
                                elminarProducto(productName, productSize)
                            }
                        });
    
                    })
    
                    const btn_finalizar = document.querySelector(".btn-finalizar")
    

    
                    btn_finalizar.addEventListener("click", () => {
                        carrito_cont.style.display = "none"
                        finalizar_cont.style.display = "flex"
                    })
    
                });
                actualizarSubtotal()
            } else {
                productos_cont.innerHTML = "<p class='text-red'>No hay Productos Agregados Al carrito</p>"
                footer_carrito.style.display = "none"
            }
    }

    function actualizarSubtotal() {
        const text_subtotal = footer_carrito.querySelector('.subtotal-carrito');
        console.log(text_subtotal)
        let totalFormat = new Intl.NumberFormat('de-DE').format(pedido.total)
        text_subtotal.innerHTML = `Subtotal:  &nbsp;<strong>$${totalFormat}</strong>`;
    }

    function elminarProducto(productName, productSize) {
            // Encontrar el índice del producto en el pedido
            const productIndex = pedido.productos.findIndex(producto => producto.name === productName && producto.size === productSize);
    
            if (productIndex !== -1) {
                // Restar el precio del producto eliminado del total del pedido
                pedido.total -= pedido.productos[productIndex].precio;
                // Eliminar el producto del pedido
                pedido.productos.splice(productIndex, 1);
    
                pedido.totalProductos -= 1
                // Mostrar nuevamente el pedido actualizado
                mostrarPedido();
                // Actualizar el subtotal del carrito en la interfaz de usuario
                actualizarSubtotal();
                actualizarNProductos()
            }
    }

      function enviarPedido(nombreCompleto, direccion, barrio, telefono, detalles,metodoPago) {

        let pedidoMensaje="";

        pedido.productos.forEach(productos => {
            let precio_format = new Intl.NumberFormat('de-DE').format(productos.precio)
            console.log(productos.size)
            pedidoMensaje= pedidoMensaje + ` • ${productos.cantidad} x - ${productos.name.toUpperCase()} ${productos.size==undefined ? '' : productos.size.toUpperCase()} ($ ${precio_format})%0A`
        });
        let direccionMensaje = "";
        let split = direccion.trim().split(' ');
        for (let i = 0; i < split.length; i++) {
            if (i == 0) {
                direccionMensaje += `${split[i]}`;
            } else {
                direccionMensaje += `+${split[i]}`;
            }
        }

        direccionMensaje=direccionMensaje.replace("#","%23")

        let mensaje="";

        for (let x = 0; x < metodoPago.length; x++) {
            if(x==0){
                metodoPago[0]==metodoPago[x].toUpperCase()
            }
        }

        console.log(metodoPago)

        let totalFormat = new Intl.NumberFormat('de-DE').format(pedido.total)

        if(detalles!=""){
            mensaje = `*Pizza Station* %0A%0A*Nombre*: ${nombreCompleto} %0A%0A*Celular*: ${telefono} %0A%0A*Dirección*: "${direccionMensaje.toUpperCase()}"%0A%0A*Barrio*: "${barrio.toUpperCase()}"%0A%0A*Método de pago*: ${metodoPago.toUpperCase()} %0A%0A*Comentario*: ${detalles} %0A%0A*Pedido*: %0A%0A%20%20${pedidoMensaje} %0A*Total*: $ ${totalFormat} %0A%0A*Gracias por su pedido.*`
        } else {
            mensaje = `*Pizza Station* %0A%0A*Nombre*: ${nombreCompleto} %0A%0A*Celular*: ${telefono} %0A%0A*Dirección*: "${direccionMensaje.toUpperCase()}"%0A%0A*Barrio*: "${barrio.toUpperCase()}"%0A%0A*Método de pago*: ${metodoPago.toUpperCase()} %0A%0A*Pedido*: %0A%0A%20%20${pedidoMensaje} %0A*Total*: $ ${totalFormat} %0A%0A*Gracias por su pedido.*`
        }


        console.log(direccionMensaje)
        console.log(direccion.trim().length)
        console.log(direccionMensaje.replace("#","%23"))
        location.href = `https://api.whatsapp.com/send?phone=3152918183&text=${mensaje}`;
    }


document.addEventListener('DOMContentLoaded', function () {
    // const prevBtn = document.querySelector('.prev');
    // const nextBtn = document.querySelector('.next');
    // const boxes = document.querySelectorAll('.box');
    // const sizeButtons = document.querySelectorAll('.size-button');
    // const addButtons = document.querySelectorAll('.button-agregar');
    // const precio = document.querySelectorAll(".precio-box .precio")
    // const carrito = document.querySelector("header .carrito")
    // const salir_carrito = document.querySelector("header .salir-carrito")
    // const carrito_cont = document.querySelector(".carrito-cont")
    // const slider_cont = document.querySelector(".slider-container")
    // const filter = document.querySelector(".filter")
    // const contenedor = document.querySelector(".contenedor")
    // const footer_carrito = document.querySelector(".footer-carrito")
    // const totalProductos = document.querySelector(".totalProductos")
    // const finalizar_cont = document.querySelector(".finalizar-cont")


    // // Definimos una función constructora para los productos
    // function Pizza(name, sizes) {
    //     this.name = name;
    //     this.sizes = sizes;
    // }

    // let pizzas = [
    //     new Pizza("pizza 1", { s: "10.000", m: "20.000", l: "30.000", xl: "40.000" }),
    //     new Pizza("pizza 2", { s: "20.000", m: "30.000", l: "40.000", xl: "50.000" }),
    //     new Pizza("pizza 3", { s: "30.000", m: "40.000", l: "50.000", xl: "60.000" })
    // ];

    // let pedido = {
    //     productos: [], // Aquí se almacenarán los productos agregados al pedido
    //     total: 0,// Aquí se almacenará el total del pedido
    //     totalProductos: 0,
    // };

    // let currentIndex = 0;
    // let startX = 0;
    // let isDragging = false;

    // function actualizarNProductos() {
    //     if (pedido.totalProductos > 0) {
    //         totalProductos.style.display = "flex"
    //         totalProductos.textContent = pedido.totalProductos
    //     } else {
    //         totalProductos.style.display = "none"
    //     }
    // }

    // function mostrarPedido(cont) {
    //     console.log(pedido)
    //     limpiarPrecios()
    //     cleanButton()

    //     productos_cont = carrito_cont.querySelector(".productos-cont")
    //     productos_cont.innerHTML = "";

    //     if (pedido.productos != "") {
    //         productos_cont.innerHTML = ""
    //         footer_carrito.style.display = "flex"
    //         pedido.productos.forEach(productos => {
    //             console.log(productos)
    //             const box_produdct = document.createElement('div')
    //             box_produdct.className = "box-product"
    //             productos_cont.appendChild(box_produdct)

    //             const product_details = document.createElement('div')
    //             product_details.className = "product-details"
    //             box_produdct.appendChild(product_details)

    //             const product_info = document.createElement('div')
    //             product_info.className = "product-info"
    //             product_details.appendChild(product_info)

    //             const name_product = document.createElement('p')
    //             name_product.textContent = `${productos.cantidad}X ${productos.name} ${productos.size}`
    //             name_product.className = "pizza-name"
    //             product_info.appendChild(name_product)

    //             const product_price = document.createElement('div')
    //             product_info.appendChild(product_price)

    //             const price_product = document.createElement('p');
    //             price_product.textContent = `$${productos.precio}`;
    //             product_price.appendChild(price_product);

    //             const product_btns = document.createElement('div')
    //             product_btns.className = "product-btns"
    //             product_details.appendChild(product_btns)

    //             const btn_eliminar = document.createElement('button')
    //             btn_eliminar.className = "btn-eliminar"
    //             btn_eliminar.innerHTML = "<i class='gg-trash'></i>"
    //             product_btns.appendChild(btn_eliminar)

    //             product_btns.querySelector(".btn-eliminar").addEventListener("click", () => {
    //                 const productName = productos.name;
    //                 const productSize = productos.size;

    //                 Swal.fire({
    //                     title: "Estas Seguro De eliminar Este Producto?",
    //                     text: "Se eliminara de tu carrito",
    //                     icon: "warning",
    //                     showCancelButton: true,
    //                     confirmButtonColor: "#fa2d1e",
    //                     confirmButtonText: "Eliminar"
    //                 }).then((result) => {
    //                     if (result.isConfirmed) {
    //                         Swal.fire({
    //                             title: "Eliminado!",
    //                             text: "El producto ha sido eliminado de forma Exitosa",
    //                             icon: "success",
    //                             showConfirmButton: false,
    //                             timer: "1200"
    //                         });
    //                         elminarProducto(productName, productSize)
    //                     }
    //                 });

    //             })

    //             const btn_finalizar = document.querySelector(".btn-finalizar")


    //             btn_finalizar.addEventListener("click", () => {
    //                 carrito_cont.style.display = "none"
    //                 finalizar_cont.style.display = "flex"
    //             })

    //             const btn_enviarPedido = document.querySelector(".envio-pedido")

    //             const form_datosPedido = document.querySelector(".finalizar-cont form")

    //             const text_transferencia = document.querySelector(".text-transf")


    //             btn_enviarPedido.addEventListener("click", () => {
    //                 let nombre = form_datosPedido[0].value
    //                 let apellido = form_datosPedido[1].value

    //                 let nombreCompleto = `${nombre} ${apellido}`

    //                 let telefono = form_datosPedido[2].value

    //                 let direccion = form_datosPedido[3].value.toLowerCase()

    //                 let detalles = form_datosPedido[4].value

    //                 let radio_metodoPago = document.getElementsByName("metodoPago")

    //                 let metodoPago;

                    

    //                 for (let i = 0; i < radio_metodoPago.length; i++) {
    //                     if (radio_metodoPago[i].checked) {
    //                         metodoPago = radio_metodoPago[i].value
    //                     }
    //                 }

    //                 if ((nombre == "") || (apellido == "") || (direccion == "") || (telefono == "")) {
    //                     Swal.fire({
    //                         icon: 'error',
    //                         title: 'Oops...',
    //                         text: 'Ingrese todos los Campos!',
    //                         iconColor: "#fa2d1e",
    //                         confirmButtonColor: "#fa2d1e",
    //                         timer: 3000
    //                     });
    //                 } else {
    //                     if (telefono.length > 10) {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'Oops...',
    //                             text: 'Ingrese un Telefono Valido!',
    //                             iconColor: "#fa2d1e",
    //                             confirmButtonColor: "#fa2d1e",
    //                             timer: 3000
    //                         });
    //                     } else {
    //                         if ((direccion.includes("cra")) || (direccion.includes("kr")) || (direccion.includes("k")) || (direccion.includes("calle")) || (direccion.includes("c")) || (direccion.includes("cll"))) {

    //                             if (metodoPago != undefined) {
    //                                 // Seccion de Envio de datos despues de verificacion
    //                                 Swal.fire({
    //                                     title: "Estas Seguro de Enviar Tu pedido ?",
    //                                     text: "Verifica que los datos esten ingresados correctamente",
    //                                     icon: "warning",
    //                                     showCancelButton: true,
    //                                     confirmButtonColor: "#fa2d1e",
    //                                     confirmButtonText: "Confirmar"
    //                                 }).then((result) => {
    //                                     if (result.isConfirmed) {
    //                                         if (metodoPago == "transferencia") {
    //                                             Swal.fire({
    //                                                 text: "Para despachar su pedido primero debe enviar el comprobante de pago",
    //                                                 icon: "info",
    //                                                 showConfirmButton: false,
    //                                                 timer: 1500
    //                                             })
    //                                         }
    //                                         enviarPedido(nombreCompleto, direccion, telefono, detalles,metodoPago)
    //                                     }
    //                                 });
    //                             } else {
    //                                 Swal.fire({
    //                                     icon: 'error',
    //                                     title: 'Oops...',
    //                                     text: 'Escoja un Metodo de Pago',
    //                                     iconColor: "#fa2d1e",
    //                                     confirmButtonColor: "#fa2d1e",
    //                                     timer: 3000
    //                                 });
    //                             }

    //                         } else {
    //                             Swal.fire({
    //                                 icon: 'error',
    //                                 title: 'Oops...',
    //                                 text: 'Ingrese una Direccion Valida!',
    //                                 iconColor: "#fa2d1e",
    //                                 confirmButtonColor: "#fa2d1e",
    //                                 timer: 3000
    //                             });
    //                             console.log(direccion)
    //                         }
    //                     }
    //                 }
    //             })



    //         });
    //         actualizarSubtotal()
    //     } else {
    //         productos_cont.innerHTML = "<p class='text-red'>No hay Productos Agregados Al carrito</p>"
    //         footer_carrito.style.display = "none"
    //     }
    // }

    // function enviarPedido(nombreCompleto, direccion, telefono, detalles,metodoPago) {

    //     let pedidoMensaje="";

    //     pedido.productos.forEach(productos => {
    //         pedidoMensaje= pedidoMensaje + ` • ${productos.cantidad} x - ${productos.name.toUpperCase()} ${productos.size.toUpperCase()} ($ ${productos.precio})%0A`
    //     });
    //     let direccionMensaje = "";
    //     let split = direccion.trim().split(' ');
    //     for (let i = 0; i < split.length; i++) {
    //         if (i == 0) {
    //             direccionMensaje += `${split[i]}`;
    //         } else {
    //             direccionMensaje += `+${split[i]}`;
    //         }
    //     }

    //     direccionMensaje=direccionMensaje.replace("#","%23")

    //     let mensaje="";

    //     for (let x = 0; x < metodoPago.length; x++) {
    //         if(x==0){
    //             metodoPago[0]==metodoPago[x].toUpperCase()
    //         }
    //     }

    //     console.log(metodoPago)

    //     if(detalles!=""){
    //         mensaje = `*Pizza Station* %0A%0A*Nombre*: ${nombreCompleto} %0A%0A*Celular*: ${telefono} %0A%0A*Dirección*: "${direccionMensaje.toUpperCase()}"%0A%0A*Método de pago*: ${metodoPago.toUpperCase()} %0A%0A*Comentario*: ${detalles} %0A%0A*Pedido*: %0A%0A%20%20${pedidoMensaje} %0A*Total*: $ ${pedido.total} %0A%0A*Gracias por su pedido.*`
    //     } else {
    //         mensaje = `*Pizza Station* %0A%0A*Nombre*: ${nombreCompleto} %0A%0A*Celular*: ${telefono} %0A%0A*Dirección*: "${direccionMensaje.toUpperCase()}"%0A%0A*Método de pago*: ${metodoPago.toUpperCase()} %0A%0A*Pedido*: %0A%0A%20%20${pedidoMensaje} %0A*Total*: $ ${pedido.total} %0A%0A*Gracias por su pedido.*`
    //     }


    //     console.log(direccionMensaje)
    //     console.log(direccion.trim().length)
    //     console.log(direccionMensaje.replace("#","%23"))
    //     location.href = `https://api.whatsapp.com/send?phone=3152918183&text=${mensaje}`;
    // }

    // function actualizarSubtotal() {
    //     const text_subtotal = footer_carrito.querySelector('.subtotal-carrito');
    //     text_subtotal.innerHTML = `Subtotal:  &nbsp;<strong>$${pedido.total}</strong>`;
    // }

    // function elminarProducto(productName, productSize) {
    //     // Encontrar el índice del producto en el pedido
    //     const productIndex = pedido.productos.findIndex(producto => producto.name === productName && producto.size === productSize);

    //     if (productIndex !== -1) {
    //         // Restar el precio del producto eliminado del total del pedido
    //         pedido.total -= pedido.productos[productIndex].precio;
    //         // Eliminar el producto del pedido
    //         pedido.productos.splice(productIndex, 1);

    //         pedido.totalProductos -= 1
    //         // Mostrar nuevamente el pedido actualizado
    //         mostrarPedido();
    //         // Actualizar el subtotal del carrito en la interfaz de usuario
    //         actualizarSubtotal();
    //         actualizarNProductos()
    //     }

    //     if (pedido.total === 0) {
    //         footer_carrito.style.display = "none";
    //     } else {
    //         actualizarSubtotal();
    //     }
    // }

    // function salirPedido() {
    //     slider_cont.style.display = "flex"
    //     carrito_cont.style.display = "none"
    //     salir_carrito.style.display = "none"
    //     carrito.style.display = "flex"
    //     finalizar_cont.style.display = "none"
    // }

    // function precioAssign(index, size) {
    //     let pizza = pizzas[index];

    //     let box_active = boxes[index];
    //     let precio = pizza.sizes[size];
    //     let precio_box = box_active.querySelector(".precio-box .precio");
    //     precio_box.innerHTML = `<span>$</span> ${parseInt(precio) * 1000}`;
    // }

    // function enviarDatos() {
    //     let pizza = pizzas[currentIndex];
    //     let tamañoPizza = pedido.size;
    //     let nombrePizza = pizza.name;
    //     let precioPizza = parseInt(pizza.sizes[tamañoPizza]) * 1000;
    //     let cantidadInput = 1;
    //     console.log(cantidadInput)
    //     if (tamañoPizza != undefined) {
    //         Swal.fire({
    //             title: `${nombrePizza.toUpperCase()}`,
    //             html:
    //                 `<p>Ingresar Cantidad</p>` +
    //                 `<div class="input-group" style="display: flex;
    //                 align-items: center;
    //                 justify-content: center;
    //                 gap: 2%;">` +
    //                 `<span class="input-group-btn">` +
    //                 `<button type="button" class="btn btn-danger btn-number-minus boton-cantidad" data-type="minus" data-field="cantidad">` +
    //                 `<span class="glyphicon glyphicon-minus">-</span>` +
    //                 `</button>` +
    //                 `</span>` +
    //                 `<input type="text" id="cantidad" name="cantidad" class="form-control input-number" value="1" min="1" max="10" readonly onpaste="return false;" style="padding: 5px 9px;border: 1px solid red;border-radius: 3px;text-align: center;">` +
    //                 `<span class="input-group-btn">` +
    //                 `<button type="button" class="btn btn-success btn-number-plus boton-cantidad" data-type="plus" data-field="cantidad"` +
    //                 `<span class="glyphicon glyphicon-plus">+</span>` +
    //                 `</button>` +
    //                 `</span>` +
    //                 `</div>`,
    //             showCancelButton: true,
    //             confirmButtonText: 'Confirmar',
    //             confirmButtonColor: "#fa2d1e",
    //             cancelButtonText: 'Cancelar',
    //             showLoaderOnConfirm: true,
    //             preConfirm: () => {
    //                 const cantidad = document.getElementById('cantidad').value;
    //                 return cantidad;
    //             },
    //             allowOutsideClick: () => !Swal.isLoading()
    //         }).then((result) => {
    //             if (result.isConfirmed) {
    //                 const cantidadPizza = result.value;
    //                 console.log("Cantidad seleccionada:", cantidadPizza);
    //                 confirmar(precioPizza, cantidadPizza, nombrePizza, tamañoPizza);
    //                 limpiarPrecios()
    //                 cleanButton()
    //             } else if (result.dismiss === Swal.DismissReason.cancel) {
    //                 limpiarPrecios()
    //                 cleanButton()
    //             }
    //         });
    //         const inputCantidad = document.getElementById('cantidad');

    //         document.querySelector(".btn-number-minus").addEventListener("click", () => {
    //             let cantidad = parseInt(inputCantidad.value);
    //             if (cantidad > parseInt(inputCantidad.min)) {
    //                 cantidad--;
    //                 inputCantidad.value = cantidad;
    //             }
    //         });
    //         document.querySelector(".btn-number-plus").addEventListener("click", () => {
    //             let cantidad = parseInt(inputCantidad.value);
    //             console.log(cantidad)
    //             console.log(cantidad)
    //             if (cantidad < parseInt(inputCantidad.max)) {
    //                 cantidad++;
    //                 inputCantidad.value = cantidad;
    //             }
    //         });


    //         // Botones de incremento y decremento
    //     } else {
    //         Swal.fire({
    //             icon: 'error',
    //             title: 'Oops...',
    //             text: 'Selecciona un tamaño!',
    //             iconColor: "#fa2d1e",
    //             confirmButtonColor: "#fa2d1e",
    //             timer: 3000
    //         });
    //     }
    // }

    // function confirmar(precioPizza, cantidadPizza, nombrePizza, tamañoPizza) {


    //     Swal.fire({
    //         icon: "success",
    //         title: "Agregado!",
    //         text: "Producto Agregado Al Carrito",
    //         showConfirmButton: false,
    //         timer: 1500
    //     });

    //     let totalPizza = precioPizza * cantidadPizza
    //     // Verificar si ya hay una pizza con el mismo nombre y tamaño en el pedido
    //     let pizzaExistenteIndex = pedido.productos.findIndex(producto => producto.name === nombrePizza && producto.size === tamañoPizza);
    //     if (pizzaExistenteIndex !== -1) {
    //         // Si la pizza ya existe en el pedido, incrementar la cantidad y actualizar el precio total
    //         pedido.productos[pizzaExistenteIndex].cantidad++;
    //         pedido.productos[pizzaExistenteIndex].precio += precioPizza;
    //     } else {
    //         // Si la pizza no existe en el pedido, agregarla al arreglo de productos
    //         pedido.productos.push({ name: nombrePizza, size: tamañoPizza, cantidad: cantidadPizza, precio: precioPizza });
    //         pedido.totalProductos += 1
    //         actualizarNProductos()
    //     }
    //     pedido.total += totalPizza


    //     console.log("Producto agregado al pedido:", nombrePizza, "Tamaño:", tamañoPizza, "Cantidad:", cantidadPizza);
    //     console.log("Total del pedido:", pedido.total);
    //     console.log("Total productos:", pedido.totalProductos);

    // }

    // function limpiarPrecios() {
    //     precio.forEach(precio => {
    //         precio.innerHTML = "Selecciona Un Tamaño";
    //     });
    // }

    // function showSlide(index) {
    //     slider.style.transform = `translateX(-${index * 100}%)`;
    //     rotatePizza(index);
    //     limpiarPrecios();
    // }

    // function nextSlide() {
    //     currentIndex = (currentIndex + 1) % boxes.length;
    //     showSlide(currentIndex);
    //     cleanButton();
    // }

    // function prevSlide() {
    //     currentIndex = (currentIndex - 1 + boxes.length) % boxes.length;
    //     showSlide(currentIndex);
    //     cleanButton();
    // }

    // function rotatePizza(index) {
    //     boxes.forEach((box, i) => {
    //         if (i === index) {
    //             box.querySelector('.pizza').style.transform = 'rotate(360deg)';
    //         } else {
    //             box.querySelector('.pizza').style.transform = 'none';
    //         }
    //     });
    // }


    // nextBtn.addEventListener('click', nextSlide);
    // prevBtn.addEventListener('click', prevSlide);

    // slider.addEventListener('touchstart', (e) => {
    //     startX = e.touches[0].clientX;
    //     isDragging = true;
    // });

    // slider.addEventListener('touchmove', (e) => {
    //     if (isDragging) {
    //         const currentX = e.touches[0].clientX;
    //         const diffX = startX - currentX;

    //         if ((diffX > 12) || (diffX < -12)) {
    //             if (diffX > 12) {
    //                 nextSlide();
    //             } else if (diffX < 12) {
    //                 prevSlide();
    //             }
    //         }

    //         isDragging = false;
    //     }
    // });

    // slider.addEventListener('touchend', () => {
    //     isDragging = false;
    // });

    // carrito.addEventListener('click', mostrarPedido)

    // salir_carrito.addEventListener('click', salirPedido)

    // sizeButtons.forEach(button => {
    //     button.addEventListener('click', () => {
    //         let size = button.textContent.toLowerCase();
    //         pedido.size = size;
    //         precioAssign(currentIndex, size);
    //         cleanButton()
    //         button.className = "size-button-active";
    //     });
    // });

    // function cleanButton() {
    //     sizeButtons.forEach(buttons => {
    //         buttons.className = "size-button"
    //     })
    // }

    // addButtons.forEach(button => {
    //     button.addEventListener('click', enviarDatos)
    // })

});
