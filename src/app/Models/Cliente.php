<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    
    protected $fillable = [
        'id',
        'nome',
        'sobre_nome',
        'endereco',
        'bairro',
        'cidade',
        'uf',
        'cep'
    ];

    public $timestamps = false;
}
