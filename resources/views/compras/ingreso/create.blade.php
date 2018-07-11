@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<h3>Nuevo Ingreso</h3>
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
	<!-- llama al resource categoriaController y con el metodo post llama al metodo store -->
	{!! Form::open(['url' => 'compras/ingreso', 'method'=>'POST', 'autocomplete'=>'off']) !!}
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<label for="proveedor">Proveedor:</label>
				<select name="idproveedor" id="idproveedor" class="form-control">
					@foreach ($personas as $persona)
						<option value="{{ $persona->idpersona }}">{{ $persona->nombre }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-4 col-xs-12">
			<div class="form-group">
				<label for="direccion">Comprobante</label>
				<select name="tipo_comprobante" class="form-control">
					<option value="Boleta">Boleta</option>
					<option value="Factura">Factura</option>
					<option value="Ticket">Ticket</option>
				</select>
			</div>
		</div>
		<div class="col-sm-3 col-xs-12">
			<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<input type="text" name="serie_comprobante" value="{{ old('serie_comprobante') }}" class="form-control" placeholder="Serie comprobante">
			</div>
		</div>
		<div class="col-sm-3 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<input type="text" name="num_comprobante" required value="{{ old('num_comprobante') }}" class="form-control" placeholder="Número comprobante">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-md-3 col-xs-12">
					<div class="form-group">
						<label for="proveedor">Artículo:</label>
						<select name="pidarticulo" id="pidarticulo" class="form-control">
							@foreach ($articulos as $articulo)
								<option value="{{ $articulo->idarticulo }}">{{ $articulo->articulo }}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
@endsection