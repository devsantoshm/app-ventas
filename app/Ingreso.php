<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingreso';
    protected $primaryKey = 'idingreso';
    public $timestamps = false; //no registre fechas
    protected $fillable = [
    	'idproveedor', 
    	'tipo_comprobante', 
    	'serie_comprobante',
    	'num_comprobante',
    	'fecha_hora',
    	'impuesto',
    	'estado'
    ];
}
