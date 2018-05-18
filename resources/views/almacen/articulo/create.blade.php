@extends('layouts.admin')
@section('contenido')
	<div class="row">
		<div class="col-sm-6 col-xs-12">
			<h3>Nueva Categoría</h3>
			@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
			@endif
			<!-- llama al resource categoriaController y con el metodo post llama al metodo store -->
			{!! Form::open(['url' => 'almacen/categoria', 'method'=>'POST', 'autocomplete'=>'off']) !!}

			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" class="form-control" placeholder="Nombre">
			</div>
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" class="form-control" placeholder="Descripción">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
@endsection