@php
	$values 	= $values ?? false;
	$hide   	= $hide ?? [];
	$model_name	= modelName($model);
	$tab_name   = mb_strtolower(str_plural($tab ?? $model_name));
	$can_create = $can['create'] ?? auth()->user()->can('create', $model);
@endphp

@can('index', $model)
	<div class="tab-pane" id="{{ $tab_name }}">
		<div class="box-header">
			<div class="clearfix">
				@if($can_create)
					@include('control.office.toolbar.create', [
						'url'    => route("office.{$model_name}.create"),
						'values' => $values,
					])
				@endif
				@include('control.office.toolbar.dataset')
			</div>

			@include('control.office.toolbar.filter-button')
		</div>

		@include('control.office.toolbar.filter')

		@include('control.office.plate.index', [
			'dataset'			=> $dataset,
			'model'				=> $model,
			'fields'			=> $fields,
			'values'			=> $values,
			'nested'			=> true,
		])
	</div>
@endcan