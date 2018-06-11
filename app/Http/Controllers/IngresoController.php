<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Ingreso;
use App\DetalleIngreso;
use App\Http\Requests\IngresoFormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class IngresoController extends Controller
{
    public function __construct()
    {
    	
    }

    public function index(Request $request)
    {
    	if ($request) {
    		//trim — Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
    		$query = trim($request->get('searchText'));
    		// buscar al inicio o al final con %
    		$ingresos = DB::table('ingreso as i')
    			->join('persona as p','i.idproveedor','=','p.idpersona')
    			->join('detalle_ingreso as di','i.idingreso', '=', 'di.idingreso')
    			->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
    			->where('i.num_comprobante', 'LIKE', '%'.$query.'%')//buscar por el nombre o por el codigo del articulo
    			->orderBy('i.idingreso', 'desc')
    			->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')//agrupa los elementos repetidos en un solo elemento
    			->paginate(7);

    			return view('compras.ingreso.index', compact('ingresos', 'query'));
    	}
    }

    public function create()
    {
    	$personas = DB::table('persona')->where('tipo_persona', '=', 'Proveedor')->get();
    	$articulos = DB::table('articulo as art')
    			->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.idarticulo')
    			->where('art.estado', '=', 'Activo')
    			->get();

    	return view('compras.ingreso.create', compact('personas', 'articulos'));
    }
}
