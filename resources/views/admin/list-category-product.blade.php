@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Listado de Categorias</h4>

                    @if (session('message_cg_room_sucess'))
                        <div id="msg" class="alert alert-success" >
                            <p>{{session('message_cg_room_sucess')}}</p>
                        </div>
                        <script>
                            setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                        </script>
                    @endif

                    @if (session('message_cg_room_error'))
                        <div id="msg" class="alert alert-danger" >
                            <p>{{session('message_cg_room_error')}}</p>
                        </div>
                        <script>
                            setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                        </script>
                    @endif

                    @if (session('message_cg_room_edit_sucess'))
                    <div id="msg" class="alert alert-success" >
                        <p>{{session('message_cg_room_edit_sucess')}}</p>
                    </div>
                    <script>
                        setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                    </script>
                @endif

                @if (session('message_cg_room_edit_error'))
                    <div id="msg" class="alert alert-danger" >
                        <p>{{session('message_cg_room_edit_error')}}</p>
                    </div>
                    <script>
                        setTimeout(function(){ $('#msg').fadeOut() }, 4000);
                    </script>
                @endif
                    <div class="row">
                        <div class="col-sm-12 co-md-3 col-lg-3">
                            <button class="w-100 btn btn-primary" onclick="location.href='{{ route('admin/rooms/create_category') }}'">Nueva Categoria</button>
                        </div>

                    </div><br><br>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Url</th>
                                    <th>Descripcion</th>
                                    <th>Principal</th>
                                    <th class="text-center">...</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable">
                                @foreach ($list_category_rooms as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            @if ($item->url_image)
                                                <a href="{{ route('admin/downloadImage', ['model' => 3, 'id' => $item->id]) }}" target="_blank">Descargar imagen</a></td>
                                            @else
                                                Sin imagen
                                            @endif
                                        <td>{{ $item->description == null ? 'Sin descripción' : $item->description}}</td>
                                        <td>{{ $item->is_principal == 1 ? 'Si' : 'No'}}</td>
                                        <td><center>
                                            <a title="Editar" href="{{ route('admin/rooms/edit_categoryRoom', $item->id) }}"><i class="icono-feather" data-feather="edit"></i></a>
                                        </center></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection