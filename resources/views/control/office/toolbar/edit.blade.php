@php
    $values = (isset($values)) ? $values : false;
@endphp

<a class="btn btn-primary pull-right" onclick="
	ssCRUD()
		@if ($values)
			@foreach ($values as $field => $value)
				.setValue('{{ $field }}', '{{ $value }}')
			@endforeach
		@endif

		.setAction('edit')
		.load('{{ $url }}')
	;
" href="javascript: void(0);"><i class="fa fa-pencil"></i> @lang('button.office.edit')</a>
