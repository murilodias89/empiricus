<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /// estou passando os campos da tabela que vãa ser gravados
    protected $fillable = [
        'name', 'avatar', 'email', 'city'
    ];
}
