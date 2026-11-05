<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        abort_unless(in_array($request->user()->perfil, ['dono', 'funcionario'], true), 403);

        return redirect()->route('dashboard.'.$request->user()->perfil);
    }

    public function dono(Request $request): View
    {
        return view('dashboards.dono', ['clinicas' => $request->user()->clinicas()->withCount('funcionarios')->orderBy('nome')->get()]);
    }

    public function funcionario(Request $request): View
    {
        return view('dashboards.funcionario', ['funcionario' => $request->user()->funcionario()->with('clinica')->firstOrFail()]);
    }
}
