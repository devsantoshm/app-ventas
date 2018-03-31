<?php

namespace App\Http\Controllers;

use App\Categoria;
use App\Http\Requests\CategoriaFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
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
    		$categorias = DB::table('categoria')->where('nombre', 'LIKE', '%'.$query.'%')
    			->where('condicion','=','1')
    			->orderBy('idcategoria', 'desc')
    			->paginate(7);

    			return view('almacen.categoria.index', compact('categorias', 'query'));
    	}
    }

    public function create()
    {
    	return view('almacen.categoria.create');
    }

    public function store(CategoriaFormRequest $request)
    {
    	$categoria = new Categoria;
    	$categoria->nombre = $request->get('nombre');
    	$categoria->descripcion = $request->get('descripcion');
    	$categoria->condicion = '1';
    	$categoria->save();

    	return redirect('almacen/categoria');
    }

    public function show($id)
    {
    	$categoria = Categoria::findOrFail($id);

    	return view('almacen.categoria.show', compact('categoria')); 
    }

    public function edit($id)
    {
    	$categoria = Categoria::findOrFail($id);

    	return view('almacen.categoria.edit', compact('categoria'));
    }

    public function update(CategoriaFormRequest $request, $id)
    {
    	$categoria = Categoria::find($id);
        //dd($categoria);
    	$categoria->nombre = $request->get('nombre');
        //dd($categoria->nombre);
    	$categoria->descripcion = $request->get('descripcion');
        //$categoria->condicion = '1';
    	$categoria->save();
        //dd($categoria->update());

    	return redirect('almacen/categoria');
    }

    public function destroy($id)
    {
    	$categoria = Categoria::findOrFail($id);
    	$categoria->condicion = '0';
    	$categoria->update();

    	return redirect('almacen/categoria');
    }
}
