<?php

namespace App\Http\Controllers;

use App\DetalleIngreso;
use App\Http\Requests\IngresoFormRequest;
use App\Ingreso;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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

    public function store(IngresoFormRequest $request)
    {
        //con el capturador de excepciones nos aseguramos ingresar
        //los ingresos y detalle ingresos
        try{
            DB::beginTransaction();
            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->get('idproveedor');
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');

            $mytime = Carbon::now('America/Lima');
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->impuesto = '18';
            $ingreso->estado = 'A';
            $ingreso->save();

            $idarticulo = $request->get('idarticulo'); //recibo un array de idarticulos
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;

            while($cont < count($idarticulo)){
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->idingreso; //almacena el idingreso autogenerado al insertar in ingreso
                $detalle->idarticulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }

            DB::commit();

        }catch(\Exception $e){
            DB::rollback(); //anulo la transaccion si hay un error
        }

        return redirect('compras/ingreso');
    }

    public function show($id)
    {
        $ingreso = DB::table('ingreso as i')
                ->join('persona as p','i.idproveedor','=','p.idpersona')
                ->join('detalle_ingreso as di','i.idingreso', '=', 'di.idingreso')
                ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado', DB::raw('sum(di.cantidad*precio_compra) as total'))
                ->where('i.idingreso', '=', $id)
                ->first();

        $detalles = DB::table('detalle_ingreso as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
                ->where('d.idingreso', '=', $id)
                ->get();

        return view('compras.ingreso.show', compact('ingreso', 'detalles'));
    }

    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = 'C';
        $ingreso->update();

        return redirect('compras/ingreso');
    }
}
