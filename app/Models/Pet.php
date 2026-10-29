<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table("pet","id_pet")]
#[Fillable('id_pet','nm_pet','nm_especie_pet','nm_raca_pet','qt_peso_pet','id_tutor')]
class Pet extends Model
{
    //
    public function tutor(){
        return $this->belongsTo(Tutor::class,"id_tutor");
    }
}
