@php
    $values   = (isset($values))   ? $values   : false;
    $redirect = (isset($redirect)) ? $redirect : false;
@endphp

<div class="btn-group">
    <a class="btn btn-primary" onclick="ssCRUD()
        @if ($values)
            @foreach ($values as $field => $value)
                .setValue('{{ $field }}', '{{ $value }}')
            @endforeach
        @endif

        {{--
        @if ($redirect)
            .setRedirect('{{ $redirect }}')
        @endif
        --}}

        .setAction('create').load('{{ $url }}');" href="javascript: void(0);" data-toggle="tooltip" title="@lang('button.office.create')"><i class="fa fa-plus" aria-hidden="true"></i> <span>@lang('button.office.create')</span></a>
</div>
