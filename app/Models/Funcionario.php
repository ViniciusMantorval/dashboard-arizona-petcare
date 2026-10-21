<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Funcionario extends Model
{
    use HasFactory;
    protected $table = 'funcionario';
    protected $primaryKey = 'id_funcionario';

    protected $fillable = [
        'nm_funcionario',
        'nm_email_funcionario',
        'cd_cpf_funcionario',
        'cd_telefone_funcionario',
        'nm_especialidade_funcionario',

    ];
}
