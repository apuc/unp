@php
	$entity = modelEntity($model);
	$record = $entity::create($dataset, 'show');
@endphp

@foreach($groups as $group => $fields)
	<table class="table no-border doc-detail">
		<tbody>
			<tr>
				<td width="50%"></td>
				<td width="50%"><b>@lang('group.office.' . $group)</b></td>
			</tr>

			@foreach($fields as $field)
				@php
					$html = false;

					$value		= $record->property($field, 'value');
					$folder 	= $record->property($field, 'folder') ?? str_plural(mb_strtolower(class_basename(get_class($dataset))));
					$styleTD	= $classTD = $styleA = '';

					$background = $record->property($field, 'background');
					$foreground = $record->property($field, 'foreground');

					if ( filled($background) || filled($foreground) ) {
						$background = $background ?? 'inherit';
						$foreground = $foreground ?? 'inherit';

						$styleTD = " style=\"background-color: {$background}; color: {$foreground};\"";
						$styleA  = " style=\"background-color: {$background}; color: {$foreground};\"";
					}

					if (null === $value) {
						$value = trans('field.office.no');
						$url  = null;
					}
					else {
						switch ($record->property($field, 'type')) {

							case 'id':
//      	                    $value = sprintf('%08d', $field['value']);
								break;

							case 'datetime':
								$value = $value->format('d.m.Y H:i');
								break;

							case 'date':
								$value = $value->format('d.m.Y');
								break;

							case 'time':
								$value = $value->format('H:i');
								break;

							case 'string':
								break;

							case 'text':
								$value = strip_tags($value);
								break;

							case 'html':
								$html  = true;
								break;

							case 'boolean':
								$value = $value ? trans('field.office.yes') : trans('field.office.no');
								break;

							case 'money':
								$html	= true;
								$value	= number_format($value, 2, '.', '&nbsp;') . '&nbsp;' . trans('office.currency');
								break;

							case 'numeric':
								break;

							case 'attachment':
								switch(mb_strtolower(pathinfo($value, PATHINFO_EXTENSION))) {
									case 'jpg':
									case 'jpeg':
									case 'gif':
									case 'png':
									case 'bmp':
										$value = ''
											. '<a class="siteset-gallery" href="' . Storage::disk('public')->url($folder . '/' . $value) . '">'
												. '<img src="' . asset('/preview/40/40/storage/' . $folder . '/' . $value) . '" alt="">'
											. '</a>'
										;
									break;
									default:
										$value = ''
											. '<a href="' . Storage::disk('public')->url($folder . '/' . $value) . '">'
												. trans('office.downloadfile')
											. '</a>'
										;
									break;
								}
								$html  = true;
								break;

							case 'picture':
								$value = ''
									. '<a class="siteset-gallery" href="' . Storage::disk('public')->url($folder . '/' . $value) . '">'
										. '<img src="' . asset('/preview/40/40/storage/' . $folder . '/' . $value) . '" alt="">'
									. '</a>'
								;
								$html  = true;
								break;

							default:
								break;
						}

						$url = $record->property($field, 'url');
					}
				@endphp
				<tr>
					<td class="text-right">@lang('field.office.' . $field)</td>

					<td{!! $styleTD !!}>
						@if (isset($url))
							@if ($html)
								<a{!! $styleA !!} href="{{ $url }}">{!! $value !!}</a>
							@else
								<a{!! $styleA !!} href="{{ $url }}">{{ $value }}</a>
							@endif
						@else
							@if ($html)
								{!! $value !!}
							@else
								{{ $value }}
							@endif
						@endif
					</td>

				</tr>
			@endforeach
		</tbody>
	</table>
@endforeach
