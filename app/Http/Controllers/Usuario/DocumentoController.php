<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DocumentosRequeridos;
use App\Models\Documento;

class DocumentoController extends Controller
{
    public function index()
{
    $usuario = auth('usuario')->user();

    // Documentos que debe subir
    $documentosRequeridos = DocumentosRequeridos::where('id_cargo', $usuario->id_cargo)
                            ->with('tipoDocumento')
                            ->get();

    // Documentos que ya subió
    $documentosSubidos = Documento::where('id_usuario', $usuario->id_usuario)->get();

    return view('user.documentos', compact('documentosRequeridos', 'documentosSubidos'));
}

public function subirDocumento(Request $request)
{
    $request->validate([
        'id_tip_document' => 'required',
        'archivo' => 'required|file|max:5120'
    ]);

    $usuario = auth('usuario')->user();
    $archivo = $request->file('archivo');
    $ruta = $archivo->store('documentos', 'public');

    Documento::create([
        'nom_documento' => $archivo->getClientOriginalName(),
        'ruta_archivo' => $ruta,
        'fecha_vencimiento' => $request->fecha_vencimiento,
        'tamaño_archivo' => $archivo->getSize(),
        'descripcion' => $request->descripcion ?? '',
        'serial_unico' => uniqid(),
        'estado' => 'Activo',
        'tipo_mime' => $archivo->getMimeType(),
        'id_usuario' => $usuario->id_usuario,
        'id_tip_document' => $request->id_tip_document
    ]);

    return redirect()->back()->with('success', 'Documento subido correctamente');
}

}
