@php
	$entity 		= modelEntity($model);
	$model_name 	= modelName($model);
	$modal_footer	= (isset($modal_footer)) ? $modal_footer : true;
	$nested			= (isset($nested)) ? $nested : false;
@endphp

@if (!empty($dataset['rows']) AND $dataset['rows']->count())
	<div class="box-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th width="30px"></th>
						@php
							$hide = $hide ?? [];
							$row  = $dataset['rows']->first();
						@endphp
						@foreach(array_except($fields, $hide) as $field)
							<th>
								@if ($row->isSortable($field))
									@php
										$direction = $dataset['direction'] ?? 'asc';
										if ($field == $dataset['sort'])
											$direction = ($direction == 'asc' ? 'desc' : 'asc');
									@endphp

									<a href="
										?sort={{ $field }}
										&direction={{ $direction }}
										@foreach (request()->all() as $request_key => $request_value)
											@if (filled($request_value))
												@switch ($request_key)
													@case ('sort')
													@case ('direction')
														@break;

													@default
														@if (is_array($request_value))
															@if (!empty(http_build_query([$request_key => $request_value])))
																&{{ http_build_query([$request_key => $request_value]) }}
															@endif
														@else
															&{{ $request_key }}={{ $request_value }}
														@endif

														@break;
												@endswitch
											@endif
										@endforeach
									">@lang('field.office.' . $field)</a>

									@if ($field == $dataset['sort'])
										<span class="fa fa-angle-{{ $direction=='asc' ? 'down' : 'up' }}"></span>
									@endif
								@else
									@lang('field.office.' . $field)
								@endif
							</th>
						@endforeach
						<th></th>
					</tr>
				</thead>

				<tbody>
					@foreach($dataset['rows'] as $row)
						<tr>
							@php
								$record = $entity::create($row, 'index');
								$id     = $record->id();

							@endphp

							<td>
								@can('read', $row)
									@include('control.office.table.show',   [
										'route' => route("office.{$model_name}.show", $id)
									])
								@endcan
							</td>

							@foreach(array_except($fields, $hide) as $field)
								@php
									$html	= false;
									$right	= false;
									$value	= $record->property($field, 'value');
									$folder = $record->property($field, 'folder') ?? str_plural(mb_strtolower(class_basename(get_class($row))));

									if (null === $value) {
										$value = trans('field.office.no');
										$url 	= null;
									}
									else {

										switch ($record->property($field, 'type')) {

											case 'id':
	//                                          $value	= sprintf('%08d', $value);

												$right	= true;
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
												$value = str_limit(strip_tags($value), config('interface.text'));
												break;

											case 'html':
												$html	= true;
												break;

											case 'money':
												$html	= true;
												$value	= number_format($value, 2, '.', '&nbsp;') . '&nbsp;' . trans('office.currency');
												$right	= true;
												break;

											case 'numeric':
												$right	= true;
												break;

											case 'boolean':
												$value = $value ? trans('field.office.yes') : trans('field.office.no');
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
										}
									}

									$styleTD = $classTD = $styleA = '';

									$background = $record->property($field, 'background');
									$foreground = $record->property($field, 'foreground');

									if ( filled($background) || filled($foreground) ) {
										$background = $background ?? 'inherit';
										$foreground = $foreground ?? 'inherit';

										$styleTD = " style=\"background-color: {$background}; color: {$foreground};\"";
										$styleA  = " style=\"background-color: {$background}; color: {$foreground};\"";
									}

									if ($right)
										$classTD = ' class="text-right"';

									$url = $record->property($field, 'url');

								@endphp
								<td{!! $styleTD . $classTD !!}>
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
							@endforeach

							<td class="text-right" nowrap>
								@includeIf('page.office.' . $model_name . '.index-controls')

								@can('update', $row)
									@include('control.office.table.edit', [
										'route'  => route("office.{$model_name}.edit", $id),
										'values' => $values ?? false,
										'footer' => $modal_footer,
									])
								@endcan

								@can('delete', $row)
									@include('control.office.table.delete', [
										'route' => route("office.{$model_name}.destroy", $id)
									])
								@endcan
							</td>

						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="box-footer">
		{{-- dd($dataset['rows']) --}}

		@if ($nested)
			{{
				$dataset['rows']->appends([
					'sort' => $dataset['sort'],
					'direction' => $dataset['direction']
				])->fragment(str_plural(kebab_case($model_name)))->links()
			}}
		@else
			{{ $dataset['rows']->appends(request()->all())->links() }}
		@endif
	</div>
@else
	<div class="box-footer">
		@include('partial.office.alert.absent')
	</div>
@endif
