<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;


    protected $fillable = ['nome','capacidade'];




    public function reserva()
    {
        return $this->hasMany(Reserva::class,'sala_id');
    }
}
