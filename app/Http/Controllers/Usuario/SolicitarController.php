<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contrato;
use Illuminate\Support\Facades\Auth;

class SolicitarController extends Controller
{
    //
    public function listarContratos() {
        $usuarioId = Auth::user()->id_usuario; // Obtener ID del usuario autenticado

        $contratos = Contrato::where('id_usuario', $usuarioId)
                    ->with(['tipoContrato'])
                    ->orderBy('fec_ingreso', 'desc')
                    ->get();
        if ($contratos->isEmpty()) {
            return view('user.solicitar')->with('message', 'No tienes contratos disponibles.');
        }
        return view('user.solicitar', compact('contratos'));
    }
}
