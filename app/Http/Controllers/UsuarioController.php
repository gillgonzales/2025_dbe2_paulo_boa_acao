<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function index() {
        //return response()->json($this->usuario->all());//retorna todos os usuarios em json
        return view('usuarios.index', ['usuarios' => Usuario::all()]);
    }

    public function show($id) {
        //return response()->json($this->usuario->find($id));
        return view('usuarios.show', ['usuario' => Usuario::find($id)]);
    }

    public function create() {
        return view('usuarios.create');
    }

    public function store(Request $request) {
        $newUsuario = $request->all();

        if(Usuario::create($newUsuario)) {
            return redirect('/usuarios');
        } else {
            dd("Erro ao cadastrar usuário");
        }
    }

    public function edit($id) {
        $data = ['usuario' => Usuario::find($id)];

        return view('usuarios.edit', $data);
    }

    public function update(Request $request, $id) {
        $usuarioAtualizado = $request->all();

        if(!Usuario::find($id)->update($usuarioAtualizado)) {
            dd("Erro ao atualizar usuário");
        }

        return redirect('/usuarios');
    }

    public function delete($id) {
        //Deveria redirecionar para um formulário de confirmação
        if(Usuario::find($id)->delete()){
            return redirect('/usuarios');
        } else {
            dd("Erro ao excluir usuário $id");
        }
    }
}
