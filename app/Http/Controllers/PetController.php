<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $pets = DB::table('pet')
            ->where('id_tutor', '=', $id)
            ->get();

        return view('pet.index',['pets'=>$pets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tutor $tutor)
    {
        if($tutor == null){
            return "Vazio";
        }
        // return $tutor->nm_tutor;

        return view('pet.create',['tutore'=>$tutor]);
    }   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tutor $tutor)
    {
        $pet = new Pet();

        $pet->nm_pet = $request->input('nome');
        $pet->nm_especie_pet = $request->input('especie');
        $pet->nm_raca_pet = $request->input('raca');
        $pet->qt_peso_pet = $request->input('peso');

        $pet->id_tutor = $tutor->id_tutor;

        $pet->save();

        return redirect(route('tutores.pets.index',$tutor->id_tutor));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        //
    }
}
