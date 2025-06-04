<?php

namespace App\Http\Controllers\Admin;
use App\Models\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class UsuarioController extends Controller
{
    //metodo para ver
    public function index(){
    $usuarios = Usuario::paginate(25);
    return view('admin.listUser', compact('usuarios'));
    }

    //cargar usuario
    public function obtenerUsuario($id)
    {
        $usuarios = Usuario::find($id);

        if (!$usuarios) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        return response()->json($usuarios);
    }
    // eliminacion ajax
    public function eliminarUsuario($id)
    {
    $usuario = Usuario::find($id);

    if (!$usuario) {
        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

    $usuario->delete();
    return response()->json(['success' => 'Usuario eliminado correctamente']);
    }
    // buscar
    public function buscarUsuarios(Request $request)
    {
    $query = $request->input('q');

    $usuarios = Usuario::where('pri_nombre', 'LIKE', "%{$query}%")
        ->orWhere('doc_usuario', 'LIKE', "%{$query}%")
        ->get();

    return response()->json($usuarios);
    }
    // funciones para habilitar e inhabilitar
    public function inhabilitarUsuario($id){
        $usuario = Usuario::findOrFail($id);
        $usuario->id_estado = 0; // Inhabilitar usuario
        $usuario->save();

        return redirect()->back()->with('success', 'Usuario inhabilitado correctamente.');
    }

    public function habilitarUsuario($id){
        $usuario = Usuario::findOrFail($id);
        $usuario->id_estado = 1; // Habilitar usuario
        $usuario->save();

        return redirect()->back()->with('success', 'Usuario habilitado correctamente.');
    }
    // editar
    public function editarUsuario(Request $request, $id){
        $usuario = Usuario::findOrFail($id);

        // Actualizar los datos del usuario
        $usuario->update($request->except('_token'));

        return redirect()->back()->with('success', 'Usuario actualizado correctamente.');
    }




}
