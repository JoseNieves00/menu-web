@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Editar Producto</h4><br>
                    @if (session('message_product_success'))
                    <div id="msg" class="alert alert-success" >
                        <p>{{session('message_product_success')}}</p>
                    </div>
                    <script>
                        setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                    </script>
                @endif

                @if (session('message_product_error'))
                    <div id="msg" class="alert alert-danger" >
                        <p>{{session('message_product_error')}}</p>
                    </div>
                    <script>
                        setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                    </script>
                @endif
                    {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_create_product')) !!}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombre *</b></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$product->name}}">
                                </div>
                            </div>

                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Categoría *</b></label>
                                        <select class="form-control" name="id_product_category" id="id_product_category">
                                            <option value="">Seleccione...</option>
                                            @foreach ($list_category_product as $item)
                                            @if ($category->id == $item->id)
                                                <option selected value="{{ $item->id }}" style="text-transform: capitalize">{{ $item->name }}</option>    
                                            @else
                                            <option value="{{ $item->id }}" style="text-transform: capitalize">{{ $item->name }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </div><br>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><b>Descripción</b></label>
                                    <textarea class="form-control" name="description" id="description" rows="2">{{$product->description}}</textarea>
                                </div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><b>Archivo de imagen para el producto (500x500)</b></label>
                                    <input type="file" class="form-control" id="file_product" name="file_product">
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-10 col-md-8 col-sm-12">
                                        <label for=""><b>Listado de versiones del producto</b></label>
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-12">
                                        <button class="btn btn-info" type="button" onclick="detailProductVersion('','','',0,{{$product->id}})">Agregar versión</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Nombre versión</th>
                                                <th>Precio</th>
                                                <th class="text-center">...</th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodytable">
                                            @foreach ($list_version as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td style="text-transform:capitalize;">{{ $item->name }}</td>
                                                    <td style="text-transform:capitalize;">{{ $item->price }}</td>
                                                    <td><center>
                                                        <a title="Editar" href="javascript:;" onclick="detailProductVersion({{$item->id}},'{{$item->name}}',{{$item->price}},1,{{$product->id}})" ><i class="icono-feather" data-feather="edit"></i></a>
                                                        <a title="Configuración" href="javascript:;" onclick="getCategoryToppings({{$product->id_product_category}})" ><i class="icono-feather" data-feather="settings"></i></a>
                                                    </center></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="row">
                            <div class="col-sm-3"></div>
                            <div class="col-sm-6">
                                <button style="width: 100%;" type="button" class="btn btn-primary" onclick="validate()">Guardar</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div id="modalDetailProductVersion" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Detalle de la versión</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id_product_version">
                    <input type="hidden" id="id_product">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" id="name_product_version">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="">Precio</label>
                                <input type="number" class="form-control" id="price_product_version">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="$.trim($('#id_product_version').val())!='' ? updateProductVersion() : saveProductVersion()">Guardar cambios</button>
                    <button type="button" class="btn btn-secondary" onclick="$('#modalDetailProductVersion').modal('hide')">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalListCategoriesTopping" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Lista de toppings por categoria</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="id_product_version">
                    <input type="hidden" id="id_product">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="">Nombre</label>
                                <input type="text" class="form-control" id="name_product_version">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="">Precio</label>
                                <input type="number" class="form-control" id="price_product_version">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="$.trim($('#id_product_version').val())!='' ? updateProductVersion() : saveProductVersion()">Guardar cambios</button>
                    <button type="button" class="btn btn-secondary" onclick="$('#modalDetailProductVersion').modal('hide')">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var listCategoryToppings = []
        function getCategoryToppings(id){
            let url = "{{config('global.server')}}/admin/getCategoryToppings/"+id
            
            $.get(url,(response)=>{
                if(!response.error){
                } else {
                }
            })

        }

        function saveProductVersion(){
            let token = $('input[name=_token]')[0].value
            let url = "{{config('global.server')}}/admin/createProductVersion"
            let idProduct = $('#id_product').val()
            let nameProductVersion = $('#name_product_version').val()
            let priceProductVersion = $('#price_product_version').val()

            if($.trim(nameProductVersion) == ""){
                toastr.error("El nombre es requerido")
                return
            }


            if($.trim(priceProductVersion) == ""){
                toastr.error("El precio es requerido")
                return
            }

            if(parseInt(priceProductVersion)<0){
                toastr.error("El precio debe ser mayor o igual a cero")
                return
            }

            let request = {
                "_token":token,
                "id_product":idProduct,
                "name":nameProductVersion,
                "price":priceProductVersion
            }

            $.post(url,request,(response)=>{
                if(!response.error){
                    location.reload()
                    return
                } else {
                    toastr.error(response.message)
                    return
                }
            })
        }

        function updateProductVersion(){
            let token = $('input[name=_token]')[0].value
            let id = $('#id_product_version').val()
            let url = "{{config('global.server')}}/admin/updateProductVersion/"+id
            let nameProductVersion = $('#name_product_version').val()
            let priceProductVersion = $('#price_product_version').val()

            if($.trim(nameProductVersion) == ""){
                toastr.error("El nombre es requerido")
                return
            }


            if($.trim(priceProductVersion) == ""){
                toastr.error("El precio es requerido")
                return
            }

            if(parseInt(priceProductVersion)<0){
                toastr.error("El precio debe ser mayor o igual a cero")
                return
            }

            let request = {
                "_token":token,
                "name":nameProductVersion,
                "price":priceProductVersion
            }

            $.post(url,request,(response)=>{
                if(!response.error){
                    location.reload()
                    return
                } else {
                    toastr.error(response.message)
                    return
                }
            })
        }

        function detailProductVersion(idProductVersion,nameProductVersion,priceProductVersion, isEdit,idProduct){
            if(isEdit==1){
                $('#modalTitle').html("Detalle de la versión")
            } else {
                $('#modalTitle').html("Crear nueva versión")
            }

            $('#id_product_version').val(idProductVersion)
            $('#id_product').val(idProduct)
            $('#name_product_version').val(nameProductVersion)
            $('#price_product_version').val(priceProductVersion)

            $('#modalDetailProductVersion').modal('show')
        }

        function validate() {
            let name = $("#name").val()
            let price = $("#price").val()
            let id_product_category = $("#id_product_category").val()

            if($.trim(name) == ""){
                toastr.error("El nombre es requerido")
                return
            }

            if($.trim(id_product_category) == ""){
                toastr.error("La categoría es requerida")
                return
            }

            $("#frm_create_product").submit()
        }
    </script>
@endsection