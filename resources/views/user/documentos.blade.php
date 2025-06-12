@extends('user.dashboard')

@section('content')
<div class="container">
    <h2 class="mb-4">Documentos Requeridos</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tipo de Documento</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($documentosRequeridos as $requerido)
                @php
                    $documentoSubido = $documentosSubidos->firstWhere('id_tip_document', $requerido->id_tip_document);
                @endphp
                <tr>
                    <td>{{ $requerido->tipoDocumento->nom_tip_document }}</td>
                    <td>
                        @if($documentoSubido)
                            <span class="badge bg-success">Subido</span>
                        @else
                            <span class="badge bg-danger">Pendiente</span>
                        @endif
                    </td>
                    <td>
                        @if(!$documentoSubido)
                            <!-- Formulario para subir documento -->
                            <form action="{{ route('usuario.subir.documento') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_tip_document" value="{{ $requerido->id_tip_document }}">
                                <div class="mb-2">
                                    <input type="file" name="archivo" required class="form-control">
                                </div>
                                <div class="mb-2">
                                    <input type="text" name="descripcion" placeholder="Descripción (opcional)" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <label>Fecha de Vencimiento (opcional)</label>
                                    <input type="date" name="fecha_vencimiento" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">Subir Documento</button>
                            </form>
                        @else
                            <a href="{{ asset('storage/' . $documentoSubido->ruta_archivo) }}" target="_blank" class="btn btn-sm btn-success">Ver Documento</a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
