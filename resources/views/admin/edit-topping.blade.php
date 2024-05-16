@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Nuevo Topping</h4><br>
                    {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_create_topping')) !!}
                    <input type="hidden" id="id_category_topping" name="id_category_topping" value="{{$topping->id_category_topping}}">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombre *</b></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$topping->name}}">
                                </div>
                            </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label><b>Precio *</b></label>
                                        <input type="number" class="form-control" id="price" name="price" value="{{$topping->price}}">
                                    </div>
                                </div>

                        </div><br>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group d-flex flex-column" style="gap: 1vh">
                                    <label><b>Categoria *</b></label>
                                    <div id="checkboxGroup" class="d-flex justify-content-between flex-wrap">
                                        <label class="d-flex p-2" style="gap: 5px; text-transform:capitalize;"><input type="checkbox" class="checkBoxItem" value="selectAll"> Seleccionar Todos</label>
                                        @foreach ($list_categorys as $item)
                                            <label class="d-flex p-2" style="gap: 5px; text-transform:capitalize;"><input type="checkbox" class="checkBoxItem" value="{{$item->id}}">{{$item->name}}</label>
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

        $('document').ready(function(){
            let idsArray = JSON.parse(selectedIdsInput.value)
            let selects=0;
            let categoriesCheckbox=checkBoxItems.length-1
            checkBoxItems.forEach(item => {
                for (let i = 0; i < idsArray.length; i++) {
                    let id = parseInt(idsArray[i])
                    if($(item).val()==id){
                        selects+=1
                        item.checked=true
                    }
                }
            });

            if(categoriesCheckbox==idsArray.length){
                selectAllCheckbox.checked = true
            } else {
                selectAllCheckbox.checked = false
            }

    });

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

        function updateSelectedIdsInput() {
            const selectedIds = [];
            checkBoxItems.forEach(item => {
                if (item.checked && item.value !== "selectAll") {
                    selectedIds.push(item.value);
                }
            });
            selectedIdsInput.value = JSON.stringify(selectedIds);
            console.log(selectedIdsInput)
        }


        document.getElementById('checkboxGroup').addEventListener('change', function() {
            const selectedIds = [];
            checkBoxItems.forEach(item => {
                if (item.checked && item.value !== "selectAll") {
                    selectedIds.push(item.value);
                }
            });
            updateSelectedIdsInput()
        });
        function validate() {
            let name = $("#name").val()
            let price = $("#price").val()
            const selectedIdsInput = $('#id_category_topping').val();

            if($.trim(name) == ""){
                toastr.error("El nombre es requerido")
                return
            }

            if($.trim(price) == ""){
                toastr.error("El precio es requerido")
                return
            }

            if($.trim(selectedIdsInput) == ""){
                toastr.error("Seleccione la(s) Categorias")
                return
            }

            $("#frm_create_topping").submit()
            } 
    </script>
@endsection