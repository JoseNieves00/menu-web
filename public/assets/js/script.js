const boxes = document.querySelectorAll('.box');
const slider = document.querySelector('.slider');
const carrito = document.querySelector('.carrito-cont');
const contenedor = document.querySelector('.contenedor');
const footer_carrito = document.querySelector('.footer-carrito');
const sizeButtons = document.querySelectorAll('.size button');
const precio_box = document.querySelectorAll(".precio-box .precio")
const totalProductos = document.querySelector(".totalProductos")
const carrito_cont = document.querySelector(".carrito-cont")
const finalizar_cont = document.querySelector(".finalizar-cont")


$(totalProductos).hide()


$(finalizar_cont).hide()

$(carrito).hide()

actualizarNProductos()

function limpiarPrecios(){
    precio_box.forEach(precio => {
        precio.innerHTML = "";
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

function resetPrice(){
    $('.price_size').val('')
}

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
    mostrarPedido()
}

function hideCarrito(){
    $('.salir-carrito').hide()
    $('.carrito').show()
    $(contenedor).show()
    $(carrito).hide()
    finalizar_cont.style.display = "none"
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
        // limpiarPrecios();
    }

    function enviarDatos(versionName,precio,nombre) {
            let cantidadInput = 1;
            if (versionName != '') {
                Swal.fire({
                    title: `${nombre.toUpperCase()} / ${versionName.toUpperCase()}`,
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
                        confirmar(precio, cantidadProduct, nombre, versionName);
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
                    if (cantidad < parseInt(inputCantidad.max)) {
                        cantidad++;
                        inputCantidad.value = cantidad;
                    }
                });
    
    
                // Botones de incremento y decremento
            } else{
                Swal.fire({
                    icon: "error",
                    title: "Opps...",
                    text: "Seleccione una versión",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
        let id_product=0;

        function confirmar(precio, cantidad, nombre, versionName) {
            Swal.fire({
                icon: "success",
                title: "Agregado!",
                text: "Producto Agregado Al Carrito",
                showConfirmButton: false,
                timer: 1500
            });
        
            let totalProducto = precio * cantidad;
            actualizarNProductos();
        

            let pedidoString = localStorage.getItem('pedido');
            
            let pedido = pedidoString ? JSON.parse(pedidoString) : { productos: [], total: 0, totalProductos: 0 };

                let productoExistente = pedido.productos.findIndex(producto => producto.version === versionName);
                if (productoExistente !== -1) {
                    pedido.productos[productoExistente].cantidad += parseInt(cantidad);
                    pedido.productos[productoExistente].precio += parseInt(precio);
                } else {
                    id_product+=1;
                    pedido.productos.push({ id:id_product,name: nombre, cantidad: parseInt(cantidad), precio: parseInt(precio), version: versionName });
                    pedido.totalProductos += 1;
                }
            pedido.total += totalProducto;
        

            localStorage.setItem('pedido', JSON.stringify(pedido));
            setTimeout(() => {
                location.href = `https://bksoluciones.com/menu_web/public/`
            }, "1000");
        }
        

    function actualizarNProductos() {
        const pedidoString = localStorage.getItem('pedido');
        const pedido = JSON.parse(pedidoString)
        if(pedido){
            if(pedido.totalProductos!=0){
                totalProductos.style.display = "flex"
                totalProductos.textContent = pedido.totalProductos
            } else {
                totalProductos.style.display = "none"
            }
        } else {
            totalProductos.style.display = "none"
        }
    }

    function mostrarPedido() {
        actualizarNProductos()
        // Recuperar el objeto pedido del localStorage
        const pedidoString = localStorage.getItem('pedido');
        const pedido = JSON.parse(pedidoString);
        if (pedidoString) {
            if(pedido.totalProductos!=0){
                carrito_cont.querySelector(".text-red").style.display="none"
                carrito_cont.querySelector(".productos-cont").style.display="flex"
                limpiarPrecios();
                cleanButton();
        
                productos_cont = carrito_cont.querySelector(".productos-cont");
                productos_cont.innerHTML = "";
        
                productos_cont.innerHTML = "";
                footer_carrito.style.display = "flex";
                pedido.productos.forEach(productos => {
                    const box_produdct = document.createElement('div');
                    box_produdct.className = "box-product";
                    productos_cont.appendChild(box_produdct);
    
                    const product_details = document.createElement('div');
                    product_details.className = "product-details";
                    box_produdct.appendChild(product_details);
    
                    const product_info = document.createElement('div');
                    product_info.className = "product-info";
                    product_details.appendChild(product_info);
    
                    const name_product = document.createElement('p');
                    name_product.textContent = `${productos.cantidad}X ${productos.name}  /  ${productos.version}`;
                    name_product.className = "product-name m-0";
                    product_info.appendChild(name_product);
    
                    const product_price = document.createElement('div');
                    product_info.appendChild(product_price);
    
                    const price_product = document.createElement('p');
                    price_product.className = "product-price m-0";
                    let precioFormat = new Intl.NumberFormat('de-DE').format(productos.precio);
                    price_product.textContent = `$${precioFormat}`;
                    product_price.appendChild(price_product);
    
                    const product_btns = document.createElement('div');
                    product_btns.className = "product-btns";
                    product_details.appendChild(product_btns);
    
                    const btn_eliminar = document.createElement('button');
                    btn_eliminar.className = "btn-eliminar";
                    btn_eliminar.innerHTML = "<i class='gg-trash'></i>";
                    product_btns.appendChild(btn_eliminar);
    
                    product_btns.querySelector(".btn-eliminar").addEventListener("click", () => {
                        const productId = productos.id;
    
    
                        Swal.fire({
                            title: "Esta seguro de eliminar este producto?",
                            text: "Se eliminara de tu carrito",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#fa2d1e",
                            confirmButtonText: "Eliminar",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: "Eliminado!",
                                    text: "El producto ha sido eliminado de forma Exitosa",
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: "1200"
                                });
                                eliminarProducto(productId);
                            }
                        });
                    });
    
                    const btn_finalizar = document.querySelector(".btn-finalizar");
    
                    btn_finalizar.addEventListener("click", () => {
                        carrito_cont.style.display = "none";
                        finalizar_cont.style.display = "flex";
                    });
                });
                actualizarSubtotal();
            } else {
                carrito_cont.querySelector(".text-red").style.display="block"
                carrito_cont.querySelector(".productos-cont").style.display="none"
                footer_carrito.style.display = "none";
            }
        } else {
            carrito_cont.querySelector(".text-red").style.display="block"
            carrito_cont.querySelector(".productos-cont").style.display="none"
            footer_carrito.style.display = "none";
        }
    }
    

    function actualizarSubtotal() {
        const pedidoString = localStorage.getItem('pedido');
        const pedido = JSON.parse(pedidoString);
        const text_subtotal = footer_carrito.querySelector('.subtotal-carrito');
        let totalFormat = new Intl.NumberFormat('de-DE').format(pedido.total)
        text_subtotal.innerHTML = `Subtotal:  &nbsp;<strong>$${totalFormat}</strong>`;
    }

    function eliminarProducto(productId) {
        const pedidoString = localStorage.getItem('pedido');
        if (pedidoString) {
            let pedido = JSON.parse(pedidoString);
    
            const productIndex = pedido.productos.findIndex(producto => producto.id === productId);
    
            if (productIndex !== -1) {
                pedido.total -= pedido.productos[productIndex].precio;
                pedido.productos.splice(productIndex, 1);
    
                pedido.totalProductos -= 1;
                localStorage.setItem('pedido', JSON.stringify(pedido));
    
                mostrarPedido();
                actualizarSubtotal();
                actualizarNProductos();
                setTimeout(() => {
                    location.href = "https://bksoluciones.com/menu_web/public/";
                }, "1000");
            }
        }
    }

    const btn_enviarPedido = document.querySelectorAll(".envio-pedido")
    
    const form_datosPedido = document.querySelector(".finalizar-cont form")

    const text_transferencia = document.querySelector(".text-transf")

    function datosUsuario(){
        let nombre = form_datosPedido[0].value
        let apellido = form_datosPedido[1].value

        let nombreCompleto = `${nombre} ${apellido}`

        let telefono = form_datosPedido[2].value

        let direccion = form_datosPedido[3].value.toLowerCase()

        let barrio = form_datosPedido[4].value.toLowerCase()

        let observacion = form_datosPedido[5].value

        let radio_metodoPago = document.getElementsByName("metodoPago")

        let metodoPago;

        

        for (let i = 0; i < radio_metodoPago.length; i++) {
            if (radio_metodoPago[i].checked) {
                metodoPago = radio_metodoPago[i].value
            }
        }

        if ((nombre == "") || (apellido == "") || (direccion == "") || (barrio == "") || (telefono == "")) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Ingrese todos los Campos!',
                iconColor: "#fa2d1e",
                confirmButtonColor: "#fa2d1e",
                timer: 3000
            });
        } else {
            if (telefono.length != 10) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingrese un Telefono Valido!',
                    iconColor: "#fa2d1e",
                    confirmButtonColor: "#fa2d1e",
                    timer: 3000
                });
            } else {
                if ((direccion.includes("cra")) || (direccion.includes("kr")) || (direccion.includes("k")) || (direccion.includes("calle")) || (direccion.includes("c")) || (direccion.includes("cll"))) {

                    if (metodoPago != undefined) {
                        // Seccion de Envio de datos despues de verificacion
                        Swal.fire({
                            title: "Esta seguro de enviar tu pedido?",
                            text: "Verifica que los datos esten ingresados correctamente",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#fa2d1e",
                            confirmButtonText: "Confirmar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                if (metodoPago == "transferencia") {
                                    Swal.fire({
                                        text: "Para despachar su pedido primero debe enviar el comprobante de pago",
                                        icon: "info",
                                        showConfirmButton: false,
                                        timer: 2000
                                    })
                                    setTimeout(() => {
                                        enviarPedido(nombreCompleto, direccion,barrio, telefono, observacion,metodoPago)
                                    }, "2000");
                                } else {
                                    enviarPedido(nombreCompleto, direccion,barrio, telefono, observacion,metodoPago)
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Escoja un metodo de pago',
                            iconColor: "#fa2d1e",
                            confirmButtonColor: "#fa2d1e",
                            timer: 1500
                        });
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ingrese una direccion valida!',
                        iconColor: "#fa2d1e",
                        confirmButtonColor: "#fa2d1e",
                        timer: 1500
                    });
                }
            }
        }
    }
    

    function enviarPedido(nombreCompleto, direccion, barrio, telefono, observacion, metodoPago) {
    
        let pedidoMensaje = "";
    
        const pedidoString = localStorage.getItem('pedido');
        const pedido = JSON.parse(pedidoString);
    
        pedido.productos.forEach(productos => {
            let precio_format = new Intl.NumberFormat('de-DE').format(productos.precio);
            pedidoMensaje = pedidoMensaje + ` • ${productos.cantidad} x - ${productos.name.toUpperCase()}  /  ${productos.version.toUpperCase()} ($ ${precio_format})%0A`;
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
    
        direccionMensaje = direccionMensaje.replace("#", "%23");
    
        let mensaje = "";
    
        for (let x = 0; x < metodoPago.length; x++) {
            if (x == 0) {
                metodoPago[0] == metodoPago[x].toUpperCase();
            }
        }

    
        let totalFormat = new Intl.NumberFormat('de-DE').format(pedido.total);
    
        if (observacion != "") {
            mensaje = `*Pizza Station* %0A%0A*Nombre*: ${nombreCompleto} %0A%0A*Celular*: ${telefono} %0A%0A*Dirección*: "${direccionMensaje.toUpperCase()}"%0A%0A*Barrio*: "${barrio.toUpperCase()}"%0A%0A*Método de pago*: ${metodoPago.toUpperCase()} %0A%0A*Comentario*: ${observacion} %0A%0A*Pedido*: %0A%0A%20%20${pedidoMensaje} %0A*Total*: $ ${totalFormat} %0A%0A*Gracias por su pedido.*`;
        } else {
            mensaje = `*Pizza Station* %0A%0A*Nombre*: ${nombreCompleto} %0A%0A*Celular*: ${telefono} %0A%0A*Dirección*: "${direccionMensaje.toUpperCase()}"%0A%0A*Barrio*: "${barrio.toUpperCase()}"%0A%0A*Método de pago*: ${metodoPago.toUpperCase()} %0A%0A*Pedido*: %0A%0A%20%20${pedidoMensaje} %0A*Total*: $ ${totalFormat} %0A%0A*Gracias por su pedido.*`;
        }
    
    
        // Eliminar el pedido del localStorage al finalizar
        localStorage.removeItem('pedido');
    
        location.href = `https://api.whatsapp.com/send?phone=3152918183&text=${mensaje}`;
    }
    
