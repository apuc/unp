<div class="ss-crud-form">

	@includeIf('page.office.' . modelName($model) . '.create-scripts')

	<form action="{{ $action }}" method="post" onsubmit="return false;" enctype="multipart/form-data">
		{{ csrf_field() }}
		@include('control.office.plate.form', [
			'event'     => 'create',
			'action'    => $action,
			'dataset'   => $dataset,
			'model'		=> $model,
		])
	</form>
</div>