@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Nueva categoría de habitación</h4>
                    {!! Form::open(array('method' => 'POST', 'files' => true, 'id' => 'frm_edit_category_room')) !!}
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>Nombre *</b></label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$category_room->name}}">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label><b>¿Es principal?</b></label>
                                    <select name="is_principal" id="is_principal" class="form-control">
                                        <option {{ $category_room->is_principal == 0 ? 'selected' : '' }} value="0">No</option>
                                        <option {{ $category_room->is_principal == 1 ? 'selected' : '' }} value="1">Si</option>
                                    </select>
                                </div>
                            </div>
                        </div><br><br>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><b>Descripción</b></label>
                                    <textarea class="form-control" name="description" id="description" rows="2">
                                        {{$category_room->description}}
                                    </textarea>
                                </div>
                            </div>
                        </div><br><br>

                        @if ($category_room->url_image)
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <a href="{{ route('admin/downloadImage', ['model' => 3, 'id' => $category_room->id]) }}" target="_blank">Click para descargar la imagen actual</a>
                                </div>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group">
                                    <label><b>Archivo de imagen para categoría(Faltan las dimensiones)</b></label>
                                    <input type="file" class="form-control" id="file_cg_room" name="file_cg_room">
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
        $('document').ready(function(){
            $('textarea').each(function(){
                    $(this).val($(this).val().trim());
                }
            );
        });

        function validate() {
            let name = $('#name').val()
            let description = $("#description").val()

            if($.trim(name) == ""){
                toastr.error("El Nombre es requerido")
                return;
            }

            $("#frm_edit_category_room").submit();
        }
    </script>
@endsection