<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('funcionario', 'id_funcionario')]
#[Fillable('nm_funcionario', 'nm_email_funcionario', 'cd_cpf_funcionario', 'cd_telefone_funcionario', 'nm_especialidade_funcionario', 'crmv', 'clinica_id')]

class Funcionario extends Model
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clinica(): BelongsTo
    {
        return $this->belongsTo(Clinica::class);
    }
}
