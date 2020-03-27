<div class="form-group row">
	<label for="{{ $field }}" class="col-sm-{{ $collabel }} col-form-label">@lang('field.office.' . $field)</label>
	<div class="col-sm-{{ $colinput }}">
		<div class="row">
			@if ('create' == $event || null === $value->$field)
				<div class="col-sm-12">
					<div data-custom-filebrowse="{{ $field }}">
						<div class="btn btn-light">
							<i class="fa fa-upload" aria-hidden="true"></i> @lang('button.office.upload')
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-check" aria-hidden="true"></i> <span></span>
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
						<input type="file" class="hidden" id="{{ $field }}" name="{{ $field }}">
					</div>
				</div>
			@else
				<div class="col-sm-2">
					@php
						$folder = str_plural(mb_strtolower(class_basename(get_class($value))));
						switch(mb_strtolower(pathinfo($value->$field, PATHINFO_EXTENSION))) {
							case 'jpg':
							case 'jpeg':
							case 'gif':
							case 'png':
							case 'bmp':
								$content = ''
									. '<a class="siteset-gallery" href="' . Storage::disk('public')->url($folder . '/' . $value->$field) . '">'
										. '<img src="' . asset('/preview/40/40/storage/' . $folder . '/' . $value->$field) . '" alt="">'
									. '</a>'
								;
								break;
							default:
								$content = ''
									. '<a href="' . Storage::disk('public')->url($folder . '/' . $value->$field) . '" target="_blank">'
										. trans('office.downloadfile')
									. '</a>'
								;
								break;
						}
					@endphp

					{!! $content !!}
				</div>
				<div class="col-sm-10">
					<div data-checkboxgroup="{{ $field }}" {!! $required ? 'class="hidden"' : '' !!}>
						<div class="custom-control custom-checkbox">
							<input class="custom-control-input" id="{{ $field }}_clean" name="{{ $field }}_clean" type="checkbox">
							<label for="{{ $field }}_clean" class="custom-control-label">
								@lang('button.office.delete')
							</label>
						</div>

						<div class="custom-control custom-checkbox">
							<input class="custom-control-input" id="{{ $field }}_update" type="checkbox">
							<label for="{{ $field }}_update" class="custom-control-label">
								@lang('button.office.update')
							</label>
						</div>
					</div>

					<div data-custom-filebrowse="{{ $field }}" {!! !$required ? 'class="hidden"' : '' !!}>
						<div class="btn btn-light">
							<i class="fa fa-upload" aria-hidden="true"></i> @lang('button.office.upload')
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-check" aria-hidden="true"></i> <span></span>
						</div>
						<div class="btn btn-light hidden">
							<i class="fa fa-times" aria-hidden="true"></i>
						</div>
						<input type="file" class="hidden" id="{{ $field }}" name="{{ $field }}">
					</div>
				</div>
			@endif
		</div>
	</div>
</div>

<script>
	var sitesetFilebrowseVariable_{{ $field }};
	var sitesetCheckboxgroupVariable_{{ $field }};
	$(document).ready(function () {
		sitesetFilebrowseVariable_{{ $field }} = ssFB('{{ $field }}', {
			'browse':	'.btn-light:nth-child(1)',
			'rebrowse':	'.btn-light:nth-child(2)',
			'clear':	'.btn-light:nth-child(3)',
		});
		sitesetFilebrowseVariable_{{ $field }}.init();

		sitesetCheckboxgroupVariable_{{ $field }} = ssCheckbox('{{ $field }}', {
			1: {
				'activated': function () {
					$("div[data-custom-filebrowse='{{ $field }}']").removeClass('hidden');
				},
				'deactivated': function () {
					$("div[data-custom-filebrowse='{{ $field }}']").addClass('hidden');
				}
			}
		});
		sitesetCheckboxgroupVariable_{{ $field }}.init();
	});
</script>