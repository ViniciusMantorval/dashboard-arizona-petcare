<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Table("funcionario","id_funcionario")]
#[FIllable('nm_funcionario','nm_email_funcionario','cd_cpf_funcionario','cd_telefone_funcionario','nm_especialidade_funcionario',)]

class Funcionario extends Model
{
}
