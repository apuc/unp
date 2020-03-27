@php
    $values = (isset($values)) ? $values : false;
@endphp

<a onclick="ssCRUD()
        @if ($values)
            @foreach ($values as $field => $value)
                .setValue('{{ $field }}', '{{ $value }}')
            @endforeach
        @endif
    .setAction('edit').load('{{ $route }}');" href="javascript: void(0);" class="btn btn-primary btn-sm" data-toggle="tooltip" title="@lang('button.office.edit')">
    <i class="fa fa-pencil"></i> @lang('button.office.edit')
</a>
