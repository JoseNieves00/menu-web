@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Nuevo Producto</h4><br>
                    {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_create_product')) !!}
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombre *</b></label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>Precio *</b></label>
                                    <input type="number" class="form-control" id="price" name="price">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>Categoría *</b></label>
                                    <select class="form-control" name="id_product_category" id="id_product_category">
                                        <option value="">Seleccione...</option>
                                        @foreach ($list_category_product as $item)
                                            <option value="{{ $item->has_size }}" style="text-transform: capitalize">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>¿Cuenta con televisión?</b></label>
                                    <select class="form-control" name="has_tv" id="has_tv">
                                        <option value="">Seleccione...</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>¿Cuenta con ducha?</b></label>
                                    <select class="form-control" name="has_shower" id="has_shower">
                                        <option value="">Seleccione...</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label><b>¿Cuenta con WiFi?</b></label>
                                    <select class="form-control" name="has_wifi" id="has_wifi">
                                        <option value="">Seleccione...</option>
                                        <option value="1">Si</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><b>Descripción</b></label>
                                    <textarea class="form-control" name="description" id="description" rows="2"></textarea>
                                </div>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><b>Archivo de imagen para habitación (500x500)</b></label>
                                    <input type="file" class="form-control" id="file_product" name="file_product">
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
@endsection
@section('scripts')
    <script>
        function validate() {
            let name = $("#name").val()
            let price = $("#price").val()
            let id_product_category = $("#id_product_category").val()

            if($.trim(name) == ""){
                toastr.error("El nombre es requerido")
                return
            }

            if($.trim(price) == ""){
                toastr.error("El precio es requerido")
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