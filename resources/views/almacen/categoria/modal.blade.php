
<div class="modal fade" id="modal-delete-{{ $cat->idcategoria }}">
	<form action="{{ route('categoria.destroy', $cat->idcategoria) }}" method="post">
	{{ method_field('DELETE') }}
	{{ csrf_field() }}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Eliminar Categoría</h4>
			</div>
			<div class="modal-body">
				<p>Confirme si desea eliminar <strong>{{ $cat->nombre }}</strong></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	</form>
</div>