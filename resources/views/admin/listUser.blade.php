@extends('admin.dashboard')

@section('title', 'Lista de Usuarios')
@section('content')
    <div id="content-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Lista de usuarios</h1>
        </div>

        <!-- Search Box -->
        <!-- Search Box con Botón de Agregar Producto -->
        <div class="search-container mb-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Buscar...">
                        <button class="btn btn-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                        <div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <!-- Formulario para editar producto -->
                        <form method="POST" action="">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Codigo</label>
                            <input name="txtcodigo" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Por favor, ingrese el codigo del producto</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nombre</label>
                            <input name="txtnombre" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Por favor, ingrese el nombre del producto</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Precio</label>
                            <input name="txtprecio" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Por favor, ingrese el precio del producto</div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Cantidad</label>
                            <input name="txtcantidad" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">Por favor, ingrese la cantidad de productos</div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="table-container">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Tipo de documento</th>
                        <th>Número de documento</th>
                        <th>Nombre completo</th>
                        <th>Fecha de nacimiento</th>
                        <th>Sexo</th>
                        <th>Estado civil</th>
                        <th>Dirección</th>
                        <th>Municipio</th>
                        <th>Departamento</th>
                        <th>Celular</th>
                        <th>Celular de emergencia</th>
                        <th>Correo</th>
                        <th>Estado</th>
                        <th>Cargo</th>
                        <th>EPS</th>
                        <th>Pensión</th>
                        <th>ARL</th>
                        <th>Caja Compensación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->tip_documento }}</td>
                            <td>{{ $usuario->doc_usuario }}</td>
                            <td>{{ $usuario->pri_nombre }} {{ $usuario->seg_nombre }} {{ $usuario->pri_apellido }}
                                {{ $usuario->seg_apellido }}</td>
                            <td>{{ $usuario->fec_nacimiento }}</td>
                            <td>{{ $usuario->sex_usuario }}</td>
                            <td>{{ $usuario->estado_civil }}</td>
                            <td>{{ $usuario->dir_usuario }}</td>
                            <td>{{ $usuario->municipio->nom_municipio ?? 'No encontrado' }}</td>
                            <td>{{ $usuario->departamento->nombre ?? 'No encontrado' }}</td>
                            <td>{{ $usuario->cel_usuario }}</td>
                            <td>{{ $usuario->cel_emer_usuario }}</td>
                            <td>{{ $usuario->correo_usuario }}</td>
                            <td>{{ $usuario->estado->nom_estado ?? 'No encontrado' }}</td>
                            <td>{{ $usuario->cargo->cargo ?? 'No encontrado' }}</td>
                            <td>{{ $usuario->eps->nom_eps ?? 'No encontrado' }}</td>
                            <td>{{ $usuario->pension->nom_pension ?? 'No encontrado' }}</td>
                            <td>{{ $usuario->arl->nom_arl ?? 'No encontrado' }}</td>
                            <td>{{ $usuario->cajaCompensacion->nom_caj_compen ?? 'No encontrado' }}</td>
                            <td>
                                <div class="d-flex flex-wrap">
                                    <button type="button" class="btn btn-sm btn-info btn-action" title="Documentos">
                                        <i class="fas fa-file-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-action" title="Editar usuario"
                                        data-bs-toggle="modal" data-bs-target="#editarModal{{ $usuario->id_usuario }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST"
                                        action="{{ $usuario->id_estado == 1 ? route('usuarios.inhabilitar', $usuario->id_usuario) : route('usuarios.habilitar', $usuario->id_usuario) }}">
                                        @csrf
                                        @method('POST')
                                        <button type="submit"
                                            class="btn btn-sm {{ $usuario->id_estado == 1 ? 'btn-warning' : 'btn-success' }}">
                                            {{ $usuario->id_estado == 1 ? 'Inhabilitar' : 'Habilitar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal para modificar usuario -->
                        <div class="modal fade" id="editarModal{{ $usuario->id_usuario }}" tabindex="-1"
                            aria-labelledby="editarModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">Modificar el usuario {{ $usuario->pri_nombre }}
                                            {{ $usuario->pri_apellido }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="{{ route('usuarios.editar', $usuario->id_usuario) }}">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="id_usuario" value="{{ $usuario->id_usuario }}">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="InputTip_documen" class="form-label">Tipo de
                                                            documento</label>
                                                        <select class="form-control" name="tip_documento">
                                                            <option value="C.C"
                                                                {{ $usuario->tip_documento == 'C.C' ? 'selected' : '' }}>
                                                                C.C</option>
                                                            <option value="C.E"
                                                                {{ $usuario->tip_documento == 'C.E' ? 'selected' : '' }}>
                                                                C.E</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="InputNum_documen" class="form-label">Número de
                                                            documento</label>
                                                        <input type="text" class="form-control" name="num_documento"
                                                            value="{{ old('num_documento', $usuario->doc_usuario) }}" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <button type="submit" class="btn btn-success">Guardar cambios</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Eliminar -->
                        <div class="modal fade" id="eliminarModal{{ $usuario->id_usuario }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Confirmar Eliminación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de eliminar el usuario {{ $usuario->doc_usuario }}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <form method="POST"
                                            action="{{ route('usuarios.eliminar', $usuario->id_usuario) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('js/list.js') }}"></script>
@endpush
