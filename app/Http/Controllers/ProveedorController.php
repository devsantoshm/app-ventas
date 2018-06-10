<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Persona;
use App\Http\Requests\PersonaFormRequest;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
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
    		$personas = DB::table('persona')->where('nombre', 'LIKE', '%'.$query.'%')
    			->where('tipo_persona','=','Proveedor')
    			->orwhere('num_documento', 'LIKE', '%'.$query.'%')
    			->where('tipo_persona','=','Proveedor')
    			->orderBy('idpersona', 'desc')
    			->paginate(7);

    			return view('compras.proveedor.index', compact('personas', 'query'));
    	}
    }

    public function create()
    {
    	return view('compras.proveedor.create');
    }

    public function store(PersonaFormRequest $request)
    {
    	$persona = new Persona;
    	$persona->tipo_persona = 'Proveedor';
    	$persona->nombre = $request->get('nombre');
    	$persona->tipo_documento = $request->get('tipo_documento');
    	$persona->num_documento = $request->get('num_documento');
    	$persona->direccion = $request->get('direccion');
    	$persona->telefono = $request->get('telefono');
    	$persona->email = $request->get('email');
    	$persona->save();

    	return redirect('compras/proveedor');
    }

    public function show($id)
    {
    	$persona = Persona::findOrFail($id);

    	return view('compras.proveedor.show', compact('persona')); 
    }

    public function edit($id)
    {
    	$persona = Persona::findOrFail($id);

    	return view('compras.proveedor.edit', compact('persona'));
    }

    public function update(PersonaFormRequest $request, $id)
    {
    	$persona = Persona::find($id);
        
    	$persona->nombre = $request->get('nombre');
    	$persona->tipo_documento = $request->get('tipo_documento');
    	$persona->num_documento = $request->get('num_documento');
    	$persona->direccion = $request->get('direccion');
    	$persona->telefono = $request->get('telefono');
    	$persona->email = $request->get('email');
    	$persona->save();

    	return redirect('compras/proveedor');
    }

    public function destroy($id)
    {
    	$persona = Persona::findOrFail($id);
    	$persona->tipo_persona = 'Inactivo';
    	$persona->update();

    	return redirect('compras/proveedor');
    }
}
