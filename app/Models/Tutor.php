<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;

#[Table("tutor","id_tutor")]
#[Fillable('id_tutor','nm_tutor','nm_endereco_tutor','nm_email_tutor','cd_telefone_tutor','cd_cpf_tutor')]
class Tutor extends Model
{
    //
    public function pet(){
        return $this->hasMany(Pet::class,'id_tutor');
    }
}
