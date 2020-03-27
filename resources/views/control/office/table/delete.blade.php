<button onclick="ssCRUD().setAction('destroy').destroy('{{ $route }}', '{{ csrf_token() }}', '@lang('document.destroy')');" class="btn btn-danger btn-sm btn-delete" data-toggle="tooltip" title="@lang('button.office.delete')">
    <i class="fa fa-trash"></i>
</button>