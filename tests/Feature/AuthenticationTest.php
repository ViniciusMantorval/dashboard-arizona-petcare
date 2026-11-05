<?php

use App\Models\Funcionario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

function cadastroFuncionario(array $overrides = []): array
{
    return array_replace([
        'name' => 'Ana Veterinária', 'email' => 'ana@example.test',
        'password' => 'senha-segura123', 'password_confirmation' => 'senha-segura123',
        'crmv' => 'qualquer texto', 'cd_cpf_funcionario' => '12345678901',
        'cd_telefone_funcionario' => '11999999999', 'nm_especialidade_funcionario' => 'Clínica geral',
    ], $overrides);
}
function cadastroDono(array $overrides = []): array
{
    return array_replace([
        'name' => 'Dono Teste', 'email' => 'dono@example.test',
        'password' => 'senha-segura123', 'password_confirmation' => 'senha-segura123',
        'nome_clinica' => 'Clínica Inicial',
    ], $overrides);
}

test('funcionario pode cadastrar sem clinica e com CRMV sem formato validado', function () {
    $this->post('/cadastro/funcionario', cadastroFuncionario(['perfil' => 'dono']))
        ->assertRedirect('/funcionario/dashboard');
    $user = User::where('email', 'ana@example.test')->firstOrFail();
    expect($user->perfil)->toBe('funcionario')
        ->and(Hash::check('senha-segura123', $user->password))->toBeTrue()
        ->and($user->funcionario->clinica_id)->toBeNull()
        ->and($user->funcionario->crmv)->toBe('qualquer texto');
    $this->assertAuthenticatedAs($user);
    $this->get('/funcionario/dashboard')->assertOk()->assertSee('Você ainda não está vinculado a uma clínica.');
});
test('funcionario pode escolher clinica existente', function () {
    $dono = User::factory()->create(['perfil' => 'dono']);
    $clinica = $dono->clinicas()->create(['nome' => 'Clínica A']);
    $this->post('/cadastro/funcionario', cadastroFuncionario(['clinica_id' => $clinica->id]))->assertRedirect();
    expect(Funcionario::first()->clinica_id)->toBe($clinica->id);
});
test('cadastro invalido nao deixa conta parcial', function (array $overrides, string $campo) {
    $this->post('/cadastro/funcionario', cadastroFuncionario($overrides))->assertSessionHasErrors($campo);
    $this->assertDatabaseCount('users', 0);
    $this->assertDatabaseCount('funcionario', 0);
})->with([
    'crmv ausente' => [['crmv' => ''], 'crmv'],
    'clinica inexistente' => [['clinica_id' => 999], 'clinica_id'],
    'confirmacao diferente' => [['password_confirmation' => 'outra senha'], 'password'],
]);
test('dono cria primeira clinica e pode criar outras somente em seu nome', function () {
    $outro = User::factory()->create(['perfil' => 'dono']);
    $outro->clinicas()->create(['nome' => 'Clínica privada do outro']);
    $this->post('/cadastro/dono', cadastroDono())->assertRedirect('/dono/dashboard');
    $dono = User::where('email', 'dono@example.test')->firstOrFail();
    $this->post('/clinicas', ['nome' => 'Segunda clínica', 'responsavel_id' => $outro->id])->assertRedirect('/dono/dashboard');
    expect($dono->clinicas()->count())->toBe(2);
    $this->get('/dono/dashboard')->assertOk()->assertSee('Segunda clínica')->assertDontSee('Clínica privada do outro');
});
test('dono precisa de nome da clinica', function () {
    $this->post('/cadastro/dono', cadastroDono(['nome_clinica' => '']))->assertSessionHasErrors('nome_clinica');
    $this->assertDatabaseCount('users', 0);
});
test('email deve ser unico entre perfis', function () {
    User::factory()->create(['email' => 'ana@example.test', 'perfil' => 'dono']);
    $this->post('/cadastro/funcionario', cadastroFuncionario())->assertSessionHasErrors('email');
    $this->assertDatabaseCount('funcionario', 0);
});
test('login exige senha correta e perfil correspondente', function () {
    $user = User::factory()->create(['email' => 'dono@example.test', 'perfil' => 'dono', 'password' => 'senha-segura123']);
    $this->post('/login/dono', ['email' => $user->email, 'password' => 'errada'])->assertSessionHasErrors('email');
    $this->assertGuest();
    $this->post('/login/funcionario', ['email' => $user->email, 'password' => 'senha-segura123'])->assertSessionHasErrors('email');
    $this->assertGuest();
    $this->post('/login/dono', ['email' => 'DONO@example.test', 'password' => 'senha-segura123'])->assertRedirect('/dono/dashboard');
    $this->assertAuthenticatedAs($user);
});
test('funcionario entra pelo seu login', function () {
    $this->post('/cadastro/funcionario', cadastroFuncionario())->assertRedirect();
    $this->post('/logout')->assertRedirect('/');
    $this->assertGuest();
    $this->post('/login/funcionario', ['email' => 'ana@example.test', 'password' => 'senha-segura123'])->assertRedirect('/funcionario/dashboard');
});
test('perfis nao acessam painel um do outro', function () {
    $dono = User::factory()->create(['perfil' => 'dono']);
    $this->actingAs($dono)->get('/funcionario/dashboard')->assertForbidden();
    $funcionario = User::factory()->create(['perfil' => 'funcionario']);
    $this->actingAs($funcionario)->get('/dono/dashboard')->assertForbidden();
    $this->post('/clinicas', ['nome' => 'Invasão'])->assertForbidden();
    $this->get('/funcionarios')->assertForbidden();
});
test('visitantes sao encaminhados ao login', function (string $url) {
    $this->get($url)->assertRedirect('/login');
})->with(['/dashboard', '/dono/dashboard', '/funcionario/dashboard', '/funcionarios', '/tutores']);
test('logout encerra autenticacao', function () {
    $this->actingAs(User::factory()->create(['perfil' => 'dono']))->post('/logout')->assertRedirect('/');
    $this->assertGuest();
    $this->get('/dono/dashboard')->assertRedirect('/login');
});
test('paginas publicas renderizam e perfis desconhecidos sao recusados', function () {
    foreach (['/', '/login', '/login/dono', '/login/funcionario', '/cadastro/dono', '/cadastro/funcionario'] as $url) {
        $this->get($url)->assertOk();
    }
    $this->get('/cadastro/admin')->assertNotFound();
    $this->post('/cadastro/admin', cadastroDono())->assertNotFound();
});
test('tentativas de login sao limitadas', function () {
    for ($i = 0; $i < 5; $i++) {
        $this->post('/login/dono', ['email' => 'limite@example.test', 'password' => 'errada'])->assertSessionHasErrors('email');
    }
    $this->post('/login/dono', ['email' => 'limite@example.test', 'password' => 'errada'])
        ->assertSessionHasErrors(['email' => 'Muitas tentativas. Aguarde um minuto e tente novamente.']);
});
