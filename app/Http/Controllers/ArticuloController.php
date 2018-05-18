<?php

namespace App\Http\Controllers;

use App\Articulo;
use App\Http\Requests\ArticuloFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
    			->where('a.nombre', 'LIKE', '%'.$query.'%')//buscar por el nombre o por el codigo del articulo
                ->orwhere('a.codigo', 'LIKE', '%'.$query.'%')
    			->orderBy('a.idarticulo', 'desc')
    			->paginate(7);

    			return view('almacen.articulo.index', compact('articulos', 'query'));
    	}
    }

    public function create()
    {
    	//Enviar todas las categorias activas en un combobox
    	$categorias = DB::table('categoria')->where('condicion','=','1')->get();
    	return view('almacen.articulo.create', compact('categorias'));
    }

    public function store(ArticuloFormRequest $request)
    {
    	$articulo = new Articulo;
    	$articulo->idcategoria = $request->get('idcategoria');
    	$articulo->codigo = $request->get('codigo');
    	$articulo->nombre = $request->get('nombre');
    	$articulo->stock = $request->get('stock');
    	$articulo->descripcion = $request->get('descripcion');
    	$articulo->estado = 'Activo';

    	if (Input::hasFile('imagen')) {
    		$file = Input::file('imagen');
    		$file->move(public_path(), '/imagenes/articulos/', $file->getClientOriginalName());
    		$articulo->imagen = $file->getClientOriginalName();
    	}

    	$articulo->save();

    	return redirect('almacen/articulo');
    }

    public function show($id)
    {
    	//Mostrar el detalle de un articulo
    	$articulo = Articulo::findOrFail($id);
    	return view('almacen.articulo.show', compact('articulo')); 
    }

    public function edit($id)
    {
    	$articulo = Articulo::findOrFail($id);
    	$categorias = DB::table('categoria')->where('condicion','=','1')->get();
    	return view('almacen.articulo.edit', compact('articulo', 'categorias'));
    }

    public function update(ArticuloFormRequest $request, $id)
    {
    	$articulo = Articulo::find($id);
        //dd($articulo);
    	$articulo->idcategoria = $request->get('idcategoria');
    	$articulo->codigo = $request->get('codigo');
    	$articulo->nombre = $request->get('nombre');
    	$articulo->stock = $request->get('stock');
    	$articulo->descripcion = $request->get('descripcion');

    	if (Input::hasFile('imagen')) {
    		$file = Input::file('imagen');
    		$file->move(public_path(), '/imagenes/articulos/', $file->getClientOriginalName());
    		$articulo->imagen = $file->getClientOriginalName();
    	}

    	$articulo->save();

    	return redirect('almacen/articulo');
    }

    public function destroy($id)
    {
    	$articulo = Articulo::findOrFail($id);
    	$articulo->estado = 'Inactivo';
    	$articulo->update();

    	return redirect('almacen/articulo');
    }
}
