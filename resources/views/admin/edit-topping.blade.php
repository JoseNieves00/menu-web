@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Editar Topping</h4><br>
                    {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_create_topping')) !!}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombre *</b></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $topping->name }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Precio *</b></label>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ $topping->price }}">
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group d-flex flex-column" style="gap: 1vh">
                                    <label><b>Categoria *</b></label>
                                    <div id="checkboxGroup" class="d-flex justify-content-between flex-wrap">
                                        @foreach ($list_categorys as $item)
                                            @php
                                                $isChecked = $topping->categoriesTopping->contains('id_category', $item->id);
                                            @endphp
                                            <label class="d-flex p-2" style="gap: 5px; text-transform:capitalize;">
                                                <input type="checkbox" name="categories[]" class="checkBoxItem" value="{{ $item->id }}" {{ $isChecked ? 'checked' : '' }}>
                                                {{ $item->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div><br><br>
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

            if($.trim(name) == ""){
                toastr.error("El nombre es requerido")
                return
            }

            if($.trim(price) == ""){
                toastr.error("El precio es requerido")
                return
            }

            $("#frm_create_topping").submit()
        } 
    </script>
@endsection
