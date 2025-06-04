<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contrato;
use App\Models\TipoContrato;
use App\Models\TiempoContrato;
use App\Models\EstadoContrato;
use App\Models\EstadoLaboral;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;



class ContratoController extends Controller
{
    // Mostrar todos los contratos
    public function index(){
    $contratos = Contrato::paginate(25);
    $tiposContrato = TipoContrato::all();
    $numMesesContrato = TiempoContrato::all();
    $estadosContrato = EstadoContrato::all();
    $estadoLaboral = EstadoLaboral::all();

    return view('admin.certificados', compact(
        'contratos',
        'tiposContrato',
        'numMesesContrato',
        'estadosContrato',
        'estadoLaboral'
    ));
    }

    // Crear contrato
     public function store(Request $request){
        //dd($request->all());
        try {
            $sql = DB::insert("INSERT INTO contratos (
                doc_usuario, fec_inicio, fec_final, salario, condiciones,
                id_estado_lab, id_tip_contrato, id_tiempo_cont, id_estado_cont
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", [
                $request->doc_usuario,
                $request->fec_inicio,
                $request->fec_final,
                $request->salario,
                $request->condiciones,
                $request->id_estado_laboral,
                $request->id_tip_contrato,
                $request->id_tiempo_cont,
                $request->id_estado_cont
            ]);
        } catch (\Throwable $th) {
            return redirect()->route('contratos.index')->with("Incorrecto", "Error: " . $th->getMessage());
        }
        if ($sql) {
            return redirect()->route('contratos.index')->with("Correcto", "Contrato registrado correctamente.");
        } else {
            return redirect()->route('contratos.index')->with("Incorrecto", "El insert no se ejecutó.");
        }


        return redirect()->route('contratos.index')->with("Correcto", "Contrato registrado correctamente.");
    }

    // Editar contrato
    public function update(Request $request, $id){
        $request->validate([
            'doc_usuario' => 'required|digits_between:7,10',
            'id_tip_contrato' => 'required|exists:tipo_contrato,id_tip_contrato',
            'id_tiemp_cont' => 'required|exists:tiempo_contrato,id_tiemp_cont',
            'fec_inicio' => 'required|date',
            'fec_final' => 'nullable|date',
            'salario' => 'required|numeric|min:100000|max:99999999',
            'id_estado_cont' => 'required|exists:estado_contrato,id_estado_cont'
        ]);

        $contrato = Contrato::findOrFail($id);
        $contrato->update($request->except('_token'));

        return redirect()->route('contratos.index')->with('success', 'Contrato actualizado correctamente.');
    }
    // Eliminar contrato
    public function destroy($id)
    {
        $contrato = Contrato::findOrFail($id);
        $contrato->delete();

        return redirect()->route('contratos.index')->with('success', 'Contrato eliminado correctamente.');
    }

    // Generar certificado en PDF
    public function generarCertificado($id){
        $contrato = Contrato::findOrFail($id);
        $usuario = $contrato->usuario; // Obtén el usuario relacionado
        // obtener el documento del usuario
        $docUsuario = $contrato->doc_usuario;
        //obtener si labora o laboro
        $estadoLaboral = $contrato->estadoLaboral ? $contrato->estadoLaboral->nom_estlab : 'Sin información';
        // Concatenar nombre completo
        $nombreCompleto = "{$usuario->pri_nombre} {$usuario->seg_nombre} {$usuario->pri_apellido} {$usuario->seg_apellido}";
        // Obtener el nombre del cargo
        $cargo = $usuario->cargo ? $usuario->cargo->cargo : 'Sin cargo registrado';
        // obtener el tipo del contrato
        $tipoContrato = $contrato->tipoContrato ? $contrato->tipoContrato->nom_tipo : 'Sin tipo de contrato';
         // Obtener tiempo de contrato
        $tiempoContrato = $contrato->tiempoContrato ? $contrato->tiempoContrato->tiempo : 'Sin tiempo de contrato';
        // Obtener salario
        $salario = $contrato->salario ?? 'Sin salario registrado';
        // fecha
        $fecha = $contrato->fec_inicio ?? 'Sin fecha';
          // Obtener fecha actual
        Carbon::setLocale('es');
        $dia = Carbon::now()->format('d');
        $mes = Carbon::now()->translatedFormat('F'); // Mes en español
        $año = Carbon::now()->format('Y');

        $pdf = Pdf::loadView('admin.certificado', compact('contrato', 'nombreCompleto','estadoLaboral','cargo',
        'tipoContrato','tiempoContrato','salario','fecha','docUsuario','dia','mes','año'));
        return $pdf->stream('Certificado_Contrato_'.$contrato->id_contrato.'.pdf');
    }



    public function showTipos($id){
        $contrato = Contrato::findOrFail($id);
        $tiposContrato = TipoContrato::all();
        $numMesesContrato = TiempoContrato::all();
        $estadosContrato = EstadoContrato::all();
        $estadoLaboral = EstadoLaboral::all();

    return view('admin.certificados', compact('contrato', 'tiposContrato', 'numMesesContrato', 'estadosContrato','estadoLaboral'));
    }
}
