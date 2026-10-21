<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'nm_funcionario',
        'nm_email_funcionario',
        'cd_cpf_funcionario',
        'cd_telefone_funcionario',
        'nm_especialidade_funcionario',
        'data_admissao',

    ];
}
