@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Crear Producto</h4><br>
                    {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_create_product')) !!}
                    {{-- <input type="hidden" id="id_category_topping" name="id_category_topping" value="{{ json_encode($id_toppings) }}"> --}}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombre *</b></label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Categoría *</b></label>
                                    <select class="form-control" name="id_product_category" id="id_product_category">
                                        <option value="">Seleccione...</option>
                                        @foreach ($list_categorys as $item)
                                        @if ($category->name == $item->name)
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
                                    <textarea class="form-control" name="description" id="description" rows="2"></textarea>
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
                        {{-- <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group d-flex flex-column">
                                    <label><b>Categoria *</b></label>
                                    <div id="checkboxGroup" class="d-flex justify-content-around flex-wrap">
                                        <label class="d-flex" style="gap: 5px; text-transform:capitalize;"><input type="checkbox" class="checkBoxItem" value="selectAll"> Seleccionar Todos</label>
                                        @foreach ($toppings as $item)
                                            <label class="d-flex" style="gap: 5px; text-transform:capitalize;"><input type="checkbox" class="checkBoxItem" value="{{$item->id}}">{{$item->name}}</label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div><br><br> --}}

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