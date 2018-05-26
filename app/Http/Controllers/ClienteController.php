<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Persona;
use App\Http\Requests\PersonaFormRequest;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
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
    			->where('tipo_persona','=','Cliente')
    			->orwhere('num_documento', 'LIKE', '%'.$query.'%')
    			->where('tipo_persona','=','Cliente')
    			->orderBy('idpersona', 'desc')
    			->paginate(7);

    			return view('ventas.cliente.index', compact('personas', 'query'));
    	}
    }

    public function create()
    {
    	return view('ventas.cliente.create');
    }

    public function store(PersonaFormRequest $request)
    {
    	$persona = new Persona;
    	$persona->tipo_persona = 'Cliente';
    	$persona->nombre = $request->get('nombre');
    	$persona->tipo_documento = $request->get('tipo_documento');
    	$persona->num_documento = $request->get('num_documento');
    	$persona->direccion = $request->get('direccion');
    	$persona->telefono = $request->get('telefono');
    	$persona->email = $request->get('email');
    	$persona->save();

    	return redirect('ventas/cliente');
    }

    public function show($id)
    {
    	$persona = Persona::findOrFail($id);

    	return view('ventas.cliente.show', compact('persona')); 
    }

    public function edit($id)
    {
    	$persona = Persona::findOrFail($id);

    	return view('ventas.cliente.edit', compact('persona'));
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

    	return redirect('ventas/cliente');
    }

    public function destroy($id)
    {
    	$persona = Persona::findOrFail($id);
    	$persona->tipo_persona = 'Inactivo';
    	$persona->update();

    	return redirect('ventas/cliente');
    }
}
