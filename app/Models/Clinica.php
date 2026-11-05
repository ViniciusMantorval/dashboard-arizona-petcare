<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('clinicas', 'id_clinica')]
#[Fillable(['nome'])]
class Clinica extends Model
{
    public function responsavel(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsavel_id', 'id');
    }

    public function funcionarios(): HasMany
    {
        return $this->hasMany(Funcionario::class, 'clinica_id', 'id');
    }
}
