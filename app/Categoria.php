<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'idCategoria';
    public $timestamps = false; //no registre fechas
    protected $fillable = ['nombre', 'descripcion', 'condicion']; 
}