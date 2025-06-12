@extends('admin.dashboard')

@section('tite', 'Asignación de Documentos')
@section('content')

<div class="container mt-4">
    <h1>Asignación de Documentos</h1>

    <!-- Botón para abrir el modal -->
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalRegistrar">
        Asignar Documento
    </button>

    <!-- Modal para registrar documento -->
    <div class="modal fade" id="modalRegistrar" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Asignar Documento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form id="formCrearDocumento" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Cargos -->
                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <select class="form-control" id="cargo" name="cargo" required>
                                <option value="">Seleccione</option>
                                @foreach($cargos as $cargo)
                                    <option value="{{ $cargo->id_cargo }}">{{ $cargo->cargo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Nombre Documento -->
                        <div class="mb-3">
                            <label for="documento" class="form-label">Nombre Documento</label>
                            <input type="text" class="form-control" id="documento" name="documento" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Tabla de Documentos Asignados -->
<div class="mt-4">
    <table class="table" id="dataTable" cellspacing="0">
        <thead>
            <tr>

                <th>Documento</th>
                <th>Cargo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se cargarán los documentos por AJAX -->
        </tbody>
    </table>
</div>

<!-- Script AJAX -->
<script>
    $(document).ready(function() {
        // Cargar documentos al seleccionar un cargo
        $('#cargo').change(function() {
            let cargoId = $(this).val();
            cargarDocumentos(cargoId);
        });

        // Guardar documento
        $('#formCrearDocumento').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('admin.guardar.documentos') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#modalRegistrar').modal('hide');
                    cargarDocumentos($('#cargo').val());
                    alert('Documento guardado exitosamente.');
                }
            });
        });

        // Cargar documentos del cargo seleccionado
        function cargarDocumentos(cargoId) {
            $.ajax({
                url: '/admin/documentos/' + cargoId,
                type: 'GET',
                success: function(response) {
                    let filas = '';
                    response.forEach(function(documento) {
                        filas += `<tr>
                            <td>${documento.id_documentos}</td>
                            <td>${documento.nom_documento}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="eliminarDocumento(${documento.id_documentos})">Eliminar</button>
                            </td>
                        </tr>`;
                    });
                    $('#tablaDocumentos tbody').html(filas);
                }
            });
        }

        // Eliminar documento
        window.eliminarDocumento = function(id) {
            if(confirm('¿Estás seguro de eliminar este documento?')) {
                $.ajax({
                    url: '/admin/documentos/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        cargarDocumentos($('#cargo').val());
                        alert('Documento eliminado.');
                    }
                });
            }
        }
    });
</script>

@endsection
