<?php

namespace App\Http\Controllers;

use App\Models\Clinica;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function loginForm(string $perfil): View
    {
        return view('auth.login', compact('perfil'));
    }

    public function registerForm(string $perfil): View
    {
        return view('auth.register', ['perfil' => $perfil, 'clinicas' => $perfil === 'funcionario' ? Clinica::orderBy('nome')->get() : collect()]);
    }

    public function login(Request $request, string $perfil): RedirectResponse
    {
        $request->merge(['email' => Str::lower(trim((string) $request->input('email')))]);
        $credentials = $request->validate(['email' => ['required', 'email'], 'password' => ['required', 'string']]);
        $key = 'login:'.hash('sha256', $credentials['email'].'|'.$request->ip());
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages(['email' => 'Muitas tentativas. Aguarde um minuto e tente novamente.']);
        }
        if (! Auth::attempt([...$credentials, 'perfil' => $perfil])) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages(['email' => 'E-mail ou senha inválidos para este perfil.']);
        }
        RateLimiter::clear($key);
        $request->session()->regenerate();

        return redirect()->route('dashboard.'.$perfil);
    }

    public function register(Request $request, string $perfil): RedirectResponse
    {
        $request->merge(['email' => Str::lower(trim((string) $request->input('email')))]);
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
        ];
        if ($perfil === 'funcionario') {
            $rules += [
                'crmv' => ['required', 'string', 'max:255'],
                'cd_cpf_funcionario' => ['required', 'digits:11', 'unique:funcionario,cd_cpf_funcionario'],
                'cd_telefone_funcionario' => ['required', 'digits:11'],
                'nm_especialidade_funcionario' => ['required', 'string', 'max:255'],
                'clinica_id' => ['nullable', 'integer', 'exists:clinicas,id'],
            ];
            $rules['email'][] = 'unique:funcionario,nm_email_funcionario';
        } else {
            $rules['nome_clinica'] = ['required', 'string', 'max:255'];
        }
        $data = $request->validate($rules, [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'Este :attribute já está cadastrado.',
            'confirmed' => 'A confirmação da senha não confere.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'digits' => 'O campo :attribute deve ter :digits dígitos.',
        ]);
        $user = DB::transaction(function () use ($data, $perfil): User {
            $user = User::create(['name' => $data['name'], 'email' => $data['email'], 'password' => $data['password'], 'perfil' => $perfil]);
            if ($perfil === 'funcionario') {
                $user->funcionario()->create([
                    'nm_funcionario' => $data['name'], 'nm_email_funcionario' => $data['email'],
                    'cd_cpf_funcionario' => $data['cd_cpf_funcionario'], 'cd_telefone_funcionario' => $data['cd_telefone_funcionario'],
                    'nm_especialidade_funcionario' => $data['nm_especialidade_funcionario'],
                    'crmv' => $data['crmv'], 'clinica_id' => $data['clinica_id'] ?? null,
                ]);
            } else {
                $user->clinicas()->create(['nome' => $data['nome_clinica']]);
            }

            return $user;
        });
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard.'.$perfil);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
