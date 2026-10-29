<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;
use Monolog\Logger;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tutores = Tutor::with('pet')->get();

        return view('tutor.index',["tutores"=>$tutores]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tutor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tutor = new Tutor();
        $tutor->nm_tutor = $request->input("nome");
        $tutor->nm_endereco_tutor = $request->input("endereco");
        $tutor->nm_email_tutor = $request->input("email");
        $tutor->cd_telefone_tutor = $request->input("telefone");
        $tutor->cd_cpf_tutor = $request->input("cpf");

        $tutor->save();

        return redirect('/tutores');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tutor = Tutor::findOrFail($id);

        return view('tutor.show',[
                "tutor"=> $tutor,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tutor = Tutor::find($id);

        return view('tutor.edit',["tutor"=>$tutor]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tutor = Tutor::find($id);

        $tutor->nm_tutor = $request->input("nome");
        $tutor->nm_email_tutor = $request->input("email");
        $tutor->nm_endereco_tutor = $request->input("endereco");
        $tutor->cd_telefone_tutor = $request->input("telefone");
        $tutor->cd_cpf_tutor = $request->input("cpf");

        $tutor->save();

        return redirect('/tutores');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tutor = Tutor::find($id);
        $tutor->delete();

        return redirect("/tutores");
    }
}
