@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Nuevo Topping</h4><br>
                    {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_create_topping')) !!}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombre *</b></label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Precio *</b></label>
                                        <input type="number" class="form-control" id="price" name="price">
                                    </div>
                                </div>

                        </div><br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group d-flex flex-column">
                                    <label><b>Categoria *</b></label>
                                    <div id="checkboxGroup" class="d-flex justify-content-around flex-wrap">
                                        <label class="d-flex" style="gap: 5px; text-transform:capitalize;"><input type="checkbox" class="checkBoxItem" value="selectAll"> Seleccionar Todos</label>
                                        @foreach ($list_categorys as $item)
                                            <label class="d-flex" style="gap: 5px; text-transform:capitalize;"><input type="checkbox" name="categories[]" class="checkBoxItem" value="{{$item->id}}">{{$item->name}}</label>
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
        const selectedIdsInput = document.getElementById('id_category_topping');
        const checkBoxItems = document.querySelectorAll('.checkBoxItem');
        const selectAllCheckbox = document.querySelector('input[value="selectAll"]');

        selectAllCheckbox.addEventListener('change', function() {
            if (this.checked) {
                checkBoxItems.forEach(item => {
                    item.checked = true;
                });
            } else {
                checkBoxItems.forEach(item => {
                    item.checked = false;
                });
            }
        });
        checkBoxItems.forEach(item => {
            item.addEventListener('change', function() {
                if (this.value === "selectAll") {
                    checkBoxItems.forEach(item => {
                        item.checked = this.checked;
                    });
                } else {
                    let allChecked = true;
                    checkBoxItems.forEach(item => {
                        if (item.value !== "selectAll" && !item.checked) {
                            allChecked = false;
                        }
                    });
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });


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