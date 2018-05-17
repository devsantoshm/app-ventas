<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $table = 'articulo';
    protected $primaryKey = 'idarticulo';
    public $timestamps = false; //no registre fechas
    protected $fillable = [
    	'idcategoria', 'codigo', 'nombre',
    	'stock', 'descripcion', 'imagen', 'estado'
    ];
}
