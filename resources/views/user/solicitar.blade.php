@extends('user.dashboard')

@section('title', 'Solicitar Certificados')
@section('content')
 <div class="contenedor">
    <h1>Solicitar certificados</h1>

    <div class="mb-3">
       <p>Seleccione el contrato que desea certificar</p>
      <input type="checkbox" id="selectAll" />
      <label for="selectAll"><strong>Seleccionar todo</strong></label>
    </div>

    <table id="certTable" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="background-color:rgb(4, 4, 110);">Seleccionar</th>
          <th style="background-color:rgb(4, 4, 110);">Documento </th>
          <th style="background-color:rgb(4, 4, 110);">Nombre</th>
         {{-- <th style="background-color:rgb(4, 4, 110);">Tipo</th>--}}
          <th style="background-color:rgb(4, 4, 110);">Fecha inicio</th>
          <th style="background-color:rgb(4, 4, 110);">Fecha finalización</th>
          <th style="background-color:rgb(4, 4, 110);">Motivo de solicitud</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input type="checkbox" class="casilla" /></td>
          <td>1106782939</td>
          <td>Luisa Lasso</td>
          <td>01/01/2025</td>
          <td></td>
          <td><textarea name="" id="miTextarea" style="resize: none; overflow: auto; height: 70px; width: 200px;font-size:12px" placeholder="Escriba el motivo de porque solicita..."></textarea></td>
        </tr>
        <tr>
          <td><input type="checkbox" class="casilla" /></td>
          <td>110698275</td>
          <td>Angel Herrera</td>
          <td>01/01/2025</td>
          <td></td>
          <td><textarea name="" id="miTextarea" style="resize: none; overflow: auto; height: 70px; width: 200px;">
            </textarea></td>
          {{--<button class="btn btn-sm btn-outline-primary">Ver</button>---}}
        </tr>
      </tbody>
      <tfoot>
  <tr>
    <td colspan="6" style="text-align: right">
     <button id="solicitarBtn" style="background-color: rgb(4, 4, 110); color: white; border: none; padding: 8px 16px; border-radius: 4px;">
        SOLICITAR
    </td>
  </tr>
</tfoot>
    </table>
  </div>
@push('scripts')

  <!-- JS: jQuery + DataTables -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function () {
      $('#certTable').DataTable({
        language: {
          search: "Buscar:",
          lengthMenu: "Mostrar _MENU_ registros",
          info: "Mostrando _START_ a _END_ de _TOTAL_ entradas",
          paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
          }
        }
      });

      // Seleccionar todas
      $('#selectAll').on('change', function () {
        $('.casilla').prop('checked', this.checked);
      });
    });
  </script>
  <script>
    const textarea = document.getElementById("miTextarea");
    textarea.addEventListener("mousedown", (e) => {
        e.preventDefault(); // Evita el posicionamiento normal
        textarea.setSelectionRange(0, 0); // Lleva el cursor al inicio
        textarea.focus(); // Enfoca el textarea
    });
</script>
@endpush
@endsection
