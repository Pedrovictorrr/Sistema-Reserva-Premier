<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['data','hora_inicio','hora_fim','sala_id','user_id'];

    public function convidados()
    {
        return $this->belongsToMany(Convidados::class,'convidado_reserva','reserva_id','convidado_id');
    }

    public function responsavel()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class,'sala_id');
    }


}
