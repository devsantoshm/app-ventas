<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\articulo;
use App\Http\Requests\articuloFormRequest;
use Illuminate\Support\Facades\DB;

class ArticuloController extends Controller
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
    		$articulos = DB::table('articulo as a')
    			->join('categoria as c','a.idcategoria','=','c.idcategoria')
    			->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
    			->where('a.nombre', 'LIKE', '%'.$query.'%')
    			->orderBy('a.idarticulo', 'desc')
    			->paginate(7);

    			return view('almacen.articulo.index', compact('articulos', 'query'));
    	}
    }

    public function create()
    {
    	return view('almacen.articulo.create');
    }

    public function store(articuloFormRequest $request)
    {
    	$articulo = new articulo;
    	$articulo->nombre = $request->get('nombre');
    	$articulo->descripcion = $request->get('descripcion');
    	$articulo->condicion = '1';
    	$articulo->save();

    	return redirect('almacen/articulo');
    }

    public function show($id)
    {
    	$articulo = articulo::findOrFail($id);

    	return view('almacen.articulo.show', compact('articulo')); 
    }

    public function edit($id)
    {
    	$articulo = articulo::findOrFail($id);

    	return view('almacen.articulo.edit', compact('articulo'));
    }

    public function update(articuloFormRequest $request, $id)
    {
    	$articulo = articulo::find($id);
        //dd($articulo);
    	$articulo->nombre = $request->get('nombre');
        //dd($articulo->nombre);
    	$articulo->descripcion = $request->get('descripcion');
        //$articulo->condicion = '1';
    	$articulo->save();
        //dd($articulo->update());

    	return redirect('almacen/articulo');
    }

    public function destroy($id)
    {
    	$articulo = articulo::findOrFail($id);
    	$articulo->condicion = '0';
    	$articulo->update();

    	return redirect('almacen/articulo');
    }
}
