<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Convidados extends Model
{
    use HasFactory;

    protected $fillable = ['nome','documento','telefone','avatar_url','data_nascimento','user_id'];

    public function reserva()
    {
        return $this->belongsToMany(Reserva::class,'convidado_reserva');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
