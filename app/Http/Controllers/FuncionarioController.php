<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $funcionarios = Funcionario::all();

        return view('funcionarios.index', [
            'funcionarios' => $funcionarios,
            'title' => 'Funcionarios',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('funcionarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $dados = $request->validate([
        'nm_funcionario' => 'required|string|max:255',
        'nm_email_funcionario' => 'required|email|max:255|unique:funcionario,nm_email_funcionario',
        'cd_cpf_funcionario' => 'required|digits:11|unique:funcionario,cd_cpf_funcionario',
        'cd_telefone_funcionario' => 'required|digits:11',
        'nm_especialidade_funcionario' => 'required|string|max:255',
    ]);

    Funcionario::create($dados);

    return redirect()->route('funcionarios.index')
        ->with('success', 'Funcionário cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Funcionario $funcionario)
    {
            return redirect()->route('funcionarios.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $funcionario = Funcionario::findOrFail($id);
        return view('funcionarios.edit', [
            'funcionario' => $funcionario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
    $funcionario = Funcionario::findOrFail($id);

    $dados = $request->validate([
        'nm_funcionario' => 'required|string|max:255',
        'nm_email_funcionario' => [
            'required', 'email', 'max:255',
            Rule::unique('funcionario', 'nm_email_funcionario')
                ->ignore($funcionario->id_funcionario, 'id_funcionario'),
        ],
        'cd_cpf_funcionario' => [
            'required', 'digits:11',
            Rule::unique('funcionario', 'cd_cpf_funcionario')
                ->ignore($funcionario->id_funcionario, 'id_funcionario'),
        ],
        'cd_telefone_funcionario'      => 'required|digits:11',
        'nm_especialidade_funcionario' => 'required|string|max:255',
    ]);

    $funcionario->update($dados);

    return redirect()->route('funcionarios.index')
        ->with('success', 'Funcionário atualizado com sucesso!');
}
    

    public function destroy(string $id)
    {
   $funcionario = Funcionario::findOrFail($id);
    $funcionario->delete();

    return redirect()->route('funcionarios.index')
        ->with('success', 'Funcionário excluído com sucesso!');
    }
}
