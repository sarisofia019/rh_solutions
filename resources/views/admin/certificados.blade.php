@extends('admin.dashboard')
@section('title', 'Certificados')
@section('content')
<div class="container">
    <h1>Gestión de Certificados</h1>
        <div>
            <!-- Botón para abrir el Modal de Crear -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearContrato">
                Crear Certificado
            </button>
        </div>

    <!-- Tabla de Contratos -->
    <table class="table table-bordered table-light mt-3">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Documento</th>
                <th>Estado</th>
                <th>Tipo de contrato</th>
                <th>Tiempo</th>
                <th>Fecha inicio</th>
                <th>Fecha finalización</th>
                <th>Salario</th>
                <th>Estado contrato</th>
                <th>Condiciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contratos as $contrato)
            <tr>
                <td>{{ $contrato->id_contrato }}</td>
                <td>{{ $contrato->doc_usuario }}</td>
                <td>{{ $contrato->estadoLaboral ? $contrato->estadoLaboral->nom_estlab : 'N/A' }}</td>
                <td>{{ $contrato->tipoContrato ? $contrato->tipoContrato->nom_tipo : 'N/A' }}</td>
                <td>{{ $contrato->tiempoContrato ? $contrato->tiempoContrato->tiempo : 'N/A' }}</td>
                <td>{{ $contrato->fec_inicio }}</td>
                <td>{{ $contrato->fec_final }}</td>
                <td>{{ $contrato->salario }}</td>
                <td>{{ $contrato->estadoContrato ? $contrato->estadoContrato->nom_estado : 'N/A' }}</td>
                <td>{{ $contrato->condiciones }}</td>
                <td>
                    <!-- Botón para generar certificado -->
                    <a href="{{ route('contratos.certificado', $contrato->id_contrato) }}" class="fas fa-fw fa-file-alt fa-lg"
                    title="Generar certificado" target="_blank"></a>
                    <!-- Botón Editar -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditarContrato"
                        data-id="{{ $contrato->id_contrato }}">Editar</button>

                    <!-- Botón Eliminar -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalEliminarContrato"
                        data-id="{{ $contrato->id_contrato }}">Eliminar</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- MODAL PARA CREAR CONTRATO -->
<div class="modal fade" id="modalCrearContrato" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header custom-header text-white">
                <h5 class="modal-title">Crear Nuevo Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('contratos.store') }}">
                    @csrf
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label" for="InputNum_documen">Documento<span class="asterisco-rojo">*</span></label>
                            <input type="text" name="doc_usuario" class="form-control" required pattern="^[0-9]{7,10}$"
                                placeholder="Digite 7 a 10 dígitos" id="InputNum_documen">
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" style="color: black">¿Trabaja actualmente?
                                    <span class="asterisco-rojo">*</span>
                                </label>
                                <div>
                                    <input type="radio" id="estadoActivo" name="id_estado_laboral" value="1"
                                        {{ old('id_estado_lab', $contrato->id_estado_laboral ?? '') == 1 ? 'checked' : '' }}>
                                    <label for="estadoActivo">Si</label>

                                    <input type="radio" id="estadoInactivo" name="id_estado_laboral" value="2"
                                        {{ old('id_estado_lab', $contrato->id_estado_laboral ?? '') == 2 ? 'checked' : '' }}>
                                    <label for="estadoInactivo">No</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="InputTipo_contrato" class="form-label" style="color: black">Tipo de contrato
                                <span class="asterisco-rojo">*</span>
                            </label>
                            <select class="form-control" name="id_tip_contrato" id="InputTipo_contrato" required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach($tiposContrato as $tipo)
                                    <option value="{{ $tipo->id_tip_contrato }}">{{ $tipo->nom_tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="InputnumMes_contrato" class="form-label" style="color: black">Tiempo del contrato
                                <span class="asterisco-rojo">*</span>
                            </label>
                            <select class="form-control" name="id_tiempo_cont" id="InputnumMes_contrato" required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach($numMesesContrato as $tiempo)
                                    <option value="{{ $tiempo->id_tiempo_cont }}">{{ $tiempo->tiempo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="InputFecha_ingreso" style="color: black" class="form-label">Fecha de ingreso
                                    <span class="asterisco-rojo">*</span>
                                </label>
                                <input type="date" class="form-control" name="fec_inicio" required
                                    value="{{ old('fec_inicio', $contrato->fec_inicio ?? '') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="InputFecha_finalizacion" style="color: black" class="form-label">Fecha de finalización</label>
                                <input type="date" class="form-control" name="fec_final"
                                    value="{{ old('fec_final', $contrato->fec_final ?? '') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="InputSalario" style="color: black" class="form-label">Salario
                                    <span class="asterisco-rojo">*</span>
                                </label>
                                <input type="text" class="form-control" name="salario" id="InputSalario" required
                                    pattern="^[0-9]{6,8}$" placeholder="Digite 6 a 8 dígitos"
                                    value="{{ old('salario', $contrato->salario ?? '') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="InputEst_contrato" class="form-label" style="color: black">Estado de contrato
                                    <span class="asterisco-rojo">*</span>
                                </label>
                                <select class="form-control" name="id_estado_cont" id="InputEst_contrato" required>
                                    <option value="">Seleccione</option>
                                    @foreach($estadosContrato as $estado)
                                        <option value="{{ $estado->id_estado_cont }}"
                                            {{ old('id_estado_cont', $contrato->id_estado_cont ?? '') == $estado->id_estado_cont ? 'selected' : '' }}>
                                            {{ $estado->nom_estado }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-mb-3">
                            <div class="mb-3">
                                <label for="InputCondiciones" class="form-label" style="color: black">Condiciones</label>
                                <textarea class="form-control" name="condiciones" id="InputCondiciones" rows="5"
                                    placeholder="Ingrese las condiciones aquí">{{ old('condiciones', $contrato->condiciones ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 b-flex justify-content-start">
                        <button type="submit" class="btn btn-custom btn" name="btncrearcontrato" value="1">Crear contrato</button>
                        <button type="button" class="btn btn-custom btn" data-bs-dismiss="modal" onclick="resetForm()">Cancelar edición</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL PARA EDITAR CONTRATO -->
<div class="modal fade" id="modalEditarContrato" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Editar Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('contratos.update', ':id') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id_contrato" id="editContratoId">

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Documento *</label>
                            <input type="text" name="num_documento" class="form-control" required
                                value="{{ old('num_documento', $contrato->doc_usuario ?? '') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estado *</label>
                            <select name="est_actual" class="form-control">
                                <option value="Labora" {{ old('est_actual', $contrato->estado_actual ?? '') == 'Labora' ? 'selected' : '' }}>Sí</option>
                                <option value="Laboro" {{ old('est_actual', $contrato->estado_actual ?? '') == 'Laboro' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="InputTipo_contrato" class="form-label" style="color: black">Tipo de contrato *</label>
                            <select class="form-control" name="tip_contrato" id="InputTipo_contrato" required>
                                <option value="">Seleccione</option>
                                @foreach($tiposContrato as $tipo)
                                    <option value="{{ $tipo->tip_contrato }}"
                                        {{ old('tip_contrato', $contrato->tip_contrato ?? '') == $tipo->tip_contrato ? 'selected' : '' }}>
                                        {{ $tipo->tip_contrato }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="InputnumMes_contrato" class="form-label" style="color: black">Tiempo del contrato *</label>
                            <select class="form-control" name="numMes_contrato" id="InputnumMes_contrato" required>
                                <option value="">Seleccione</option>
                                @foreach($numMesesContrato as $tiempo)
                                    <option value="{{ $tiempo->tiempo_contrato }}"
                                        {{ old('numMes_contrato', $contrato->tiempo_contrato ?? '') == $tiempo->tiempo_contrato ? 'selected' : '' }}>
                                        {{ $tiempo->tiempo_contrato }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="InputFecha_ingreso" class="form-label" style="color: black">Fecha de ingreso *</label>
                            <input type="date" class="form-control" name="fecha_ingreso" required
                                value="{{ old('fecha_ingreso', $contrato->fec_inicio ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="InputFecha_finalizacion" class="form-label" style="color: black">Fecha de finalización</label>
                            <input type="date" class="form-control" name="fec_finalizacion"
                                value="{{ old('fec_finalizacion', $contrato->fec_final ?? '') }}">
                        </div>

                        <div class="col-md-3">
                            <label for="InputSalario" class="form-label" style="color: black">Salario *</label>
                            <input type="text" class="form-control" name="salario" id="InputSalario" required
                                pattern="^[0-9]{6,8}$" placeholder="Digite 6 a 8 dígitos"
                                value="{{ old('salario', $contrato->salario ?? '') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="InputEst_contrato" class="form-label" style="color: black">Estado de contrato *</label>
                        <select class="form-control" name="est_contrato" id="InputEst_contrato" required>
                            <option value="">Seleccione</option>
                            @foreach($estadosContrato as $estado)
                                <option value="{{ $estado->est_contrato }}"
                                    {{ old('est_contrato', $contrato->est_contrato ?? '') == $estado->est_contrato ? 'selected' : '' }}>
                                    {{ $estado->est_contrato }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-9"></div>

                    <div class="col-mb-3">
                        <label for="InputCondiciones" class="form-label" style="color: black">Condiciones</label>
                        <textarea class="form-control" name="condiciones" id="InputCondiciones" rows="5"
                            placeholder="Ingrese las condiciones aquí">{{ old('condiciones', $contrato->condiciones ?? '') }}</textarea>
                    </div>

                    <div class="modal-footer mt-3">
                        <button type="submit" class="btn btn-success">Actualizar Contrato</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- MODAL DE CONFIRMACIÓN PARA ELIMINAR CONTRATO -->
<div class="modal fade" id="modalEliminarContrato" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Eliminar Contrato</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este contrato?</p>
            </div>
            <div class="modal-footer">
                <form method="POST" action="{{ route('contratos.destroy', ':id') }}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_contrato" id="deleteContratoId">
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>
 <!-- JavaScript bundle with popper -->
@endsection
@push('scripts')
    <script src="{{ asset('js/certificados.js')}}"></script>
@endpush
