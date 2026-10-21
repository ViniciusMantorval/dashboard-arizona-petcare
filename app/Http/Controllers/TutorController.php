<?php

namespace App\Http\Controllers;

use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tutor.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
