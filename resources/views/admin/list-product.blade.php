@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Listado de Productos</h4>

                    @if (session('message_product_sucess'))
                        <div id="msg" class="alert alert-success" >
                            <p>{{session('message_product_sucess')}}</p>
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
                    <div class="row">
                        <div class="col-sm-12 co-md-3 col-lg-3">
                            <button class="w-100 btn btn-primary" onclick="location.href='{{ route('admin/product/create') }}'">Nuevo Producto</button>
                        </div>

                        <div class="col-sm-12 co-md-3 col-lg-3">
                            <button class="w-100 btn btn-primary" onclick="location.href='{{ route('admin/category_product') }}'">Listado categorías</button>
                        </div>
                    </div><br><br>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Precio Xs</th>
                                    <th>Precio S</th>
                                    <th>Precio M</th>
                                    <th>Precio L</th>
                                    <th>Precio XL</th>
                                    <th class="text-center">...</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable">
                                @foreach ($list_products as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td style="text-transform:capitalize;">{{ $item->name }}</td>
                                        <td style="text-transform:capitalize;">{{ $item->category->name }}</td>
                                        <td>${{number_format($item->price,0,'.','.')}}</td>
                                        <td>${{ number_format($item->price_xs)}}</td>
                                        <td>${{ number_format($item->price_s)}}</td>
                                        <td>${{ number_format($item->price_m)}}</td>
                                        <td>${{ number_format($item->price_l)}}</td>
                                        <td>${{ number_format($item->price_xl)}}</td>
                                        {{-- <td><center>
                                            <a title="Editar" href="{{ route('admin/product/edit', $item->id) }}"><i class="icono-feather" data-feather="edit"></i></a>
                                        </center></td> --}}
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