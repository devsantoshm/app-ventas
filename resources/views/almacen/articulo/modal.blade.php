
<div class="modal fade" id="modal-delete-{{ $art->idarticulo }}">
	<form action="{{ route('articulo.destroy', $art->idarticulo) }}" method="post">
	{{ method_field('DELETE') }}
	{{ csrf_field() }}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Eliminar Artículo</h4>
			</div>
			<div class="modal-body">
				<p>Confirme si desea eliminar <strong>{{ $art->nombre }}</strong></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	</form>
</div>