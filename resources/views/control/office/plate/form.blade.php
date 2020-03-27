@php
	$entity = modelEntity($model);
	$record = $entity::create($dataset, $event);
@endphp

@include('control.office.form.errors')

@foreach($groups as $group => $fields)
	@include('control.office.form.group', [
		'field' => $group
	])
	@foreach($fields as $column => $field)
		@php
			$control	= $record->property($field, 'control');
			$readonly	= $record->property($field, 'readonly');

			$value		= $record->property($field, 'value');
			$collabel	= filled($collabel	= $record->property($field, 'collabel'))	? $collabel	: 2;
			$colinput	= filled($colinput	= $record->property($field, 'colinput'))	? $colinput	: 10;
			$required	= filled($required	= $record->property($field, 'required'))	? $required	: false;
			$mask		= filled($mask		= $record->property($field, 'mask'))		? $mask		: null;
			$default	= filled($default	= $record->property($field, 'default'))		? $default	: false;
		@endphp
		@if ($control == 'text')
			@include('control.office.form.input-text', [
				'field'		=> $field,
				'value'		=> $value,
				'readonly'	=> $readonly ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'mask'		=> $mask,
			])
		@elseif ($control == 'textarea')
			@include('control.office.form.input-textarea', [
				'field'		=> $field,
				'value'		=> $value,
				'readonly'	=> $readonly ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'mask'		=> $mask,
			])
		@elseif ($control == 'htmleditor')
			@include('control.office.form.input-html', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'select')
			@include('control.office.form.input-select', [
				'field'		=> $field,
				'id'		=> $record->property($field, 'id'),
				'value'		=> $value,
				'options'	=> $record->property($field, 'options'),
				'lookup'	=> $record->property($field, 'lookup'),
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'search')
			@include('control.office.form.input-search', [
				'field'		=> $field,
				'id'		=> $event == 'edit' ? $record->property($field, 'id') : null,
				'value'		=> $value,
				'search'	=> $record->property($field, 'search'),
				'create'	=> $record->property($field, 'create') ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'checkbox')
			@include('control.office.form.input-checkbox', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'password')
			@include('control.office.form.input-password', [
				'field'		=> $field,
				'value'		=> $value,
				'readonly'	=> $readonly ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'picture')
			@include('control.office.form.input-picture', [
				'field'		=> $field,
				'value'		=> $record->record,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'required'	=> $required,
			])
		@elseif ($control == 'attachment')
			@include('control.office.form.input-attachment', [
				'field'		=> $field,
				'value'		=> $record->record,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'required'	=> $required,
			])
		@elseif ($control == 'date')
			@include('control.office.form.input-date', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'datetime')
			@include('control.office.form.input-datetime', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'daterange')
			@include('control.office.form.input-daterange', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@elseif ($control == 'datetimerange')
			@include('control.office.form.input-datetimerange', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			])
		@endif
	@endforeach
@endforeach
