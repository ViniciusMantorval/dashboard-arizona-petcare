<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'id_pet',
        'nm_pet',
        'nm_especie_pet',
        'nm_raca_pet',
        'qt_peso_pet',
        'id_tutor',
    ];
}
