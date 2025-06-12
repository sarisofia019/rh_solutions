<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\TipoDocumento;
use App\Models\DocumentosRequeridos;


class DocumentoAsignacionController extends Controller
{
    public function index()
{
    $cargos = Cargo::all();
    $tiposDocumentos = TipoDocumento::all();
    return view('admin.asignarDocumentos', compact('cargos', 'tiposDocumentos'));
}

public function asignarDocumentos(Request $request)
{
    $request->validate([
        'id_cargo' => 'required',
        'documentos' => 'required|array'
    ]);

    // Borrar documentos anteriores
    DocumentosRequeridos::where('id_cargo', $request->id_cargo)->delete();

    // Insertar los nuevos documentos
    foreach ($request->documentos as $docId) {
        DocumentosRequeridos::create([
            'id_cargo' => $request->id_cargo,
            'id_tip_document' => $docId,
            'obligatorio' => 1,
            'fec_creacion' => now(),
            'id_usuario' => auth('usuario')->id() // O admin logueado si lo tienes
        ]);
    }

    return redirect()->back()->with('success', 'Documentos asignados correctamente');
}

}
