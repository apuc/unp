<div class="ss-crud-form">

	@includeIf('page.office.' . modelName($model) . '.edit-scripts')

	<form class="form-horizontal" action="{{ $action }}" method="post" onsubmit="return false;" enctype="multipart/form-data">
		{{ csrf_field() }}
		{!! method_field('put') !!}
		@include('control.office.plate.form', [
			'event'     => 'edit',
			'action'    => $action,
			'dataset'   => $dataset,
			'model'		=> $model,
		])
	</form>
</div>