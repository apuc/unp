<?php
	$entity 		= modelEntity($model);
	$model_name 	= modelName($model);
	$modal_footer	= (isset($modal_footer)) ? $modal_footer : true;
	$nested			= (isset($nested)) ? $nested : false;
?>

<?php if(!empty($dataset['rows']) AND $dataset['rows']->count()): ?>
	<div class="box-body">
		<div class="table-responsive">
			<table class="table table-hover">
				<thead>
					<tr>
						<th width="30px"></th>
						<?php
							$hide = $hide ?? [];
							$row  = $dataset['rows']->first();
						?>
						<?php $__currentLoopData = array_except($fields, $hide); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<th>
								<?php if($row->isSortable($field)): ?>
									<?php
										$direction = $dataset['direction'] ?? 'asc';
										if ($field == $dataset['sort'])
											$direction = ($direction == 'asc' ? 'desc' : 'asc');
									?>

									<a href="
										?sort=<?php echo e($field); ?>

										&direction=<?php echo e($direction); ?>

										<?php $__currentLoopData = request()->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request_key => $request_value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if(filled($request_value)): ?>
												<?php switch($request_key):
													case ('sort'): ?>
													<?php case ('direction'): ?>
														<?php break; ?>;

													<?php default: ?>
														<?php if(is_array($request_value)): ?>
															<?php if(!empty(http_build_query([$request_key => $request_value]))): ?>
																&<?php echo e(http_build_query([$request_key => $request_value])); ?>

															<?php endif; ?>
														<?php else: ?>
															&<?php echo e($request_key); ?>=<?php echo e($request_value); ?>

														<?php endif; ?>

														<?php break; ?>;
												<?php endswitch; ?>
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									"><?php echo app('translator')->get('field.office.' . $field); ?></a>

									<?php if($field == $dataset['sort']): ?>
										<span class="fa fa-angle-<?php echo e($direction=='asc' ? 'down' : 'up'); ?>"></span>
									<?php endif; ?>
								<?php else: ?>
									<?php echo app('translator')->get('field.office.' . $field); ?>
								<?php endif; ?>
							</th>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php $__currentLoopData = $dataset['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<?php
								$record = $entity::create($row, 'index');
								$id     = $record->id();

							?>

							<td>
								<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('read', $row)): ?>
									<?php echo $__env->make('control.office.table.show',   [
										'route' => route("office.{$model_name}.show", $id)
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<?php endif; ?>
							</td>

							<?php $__currentLoopData = array_except($fields, $hide); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php
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

								?>
								<td<?php echo $styleTD . $classTD; ?>>
									<?php if(isset($url)): ?>
										<?php if($html): ?>
											<a<?php echo $styleA; ?> href="<?php echo e($url); ?>"><?php echo $value; ?></a>
										<?php else: ?>
											<a<?php echo $styleA; ?> href="<?php echo e($url); ?>"><?php echo e($value); ?></a>
										<?php endif; ?>
									<?php else: ?>
										<?php if($html): ?>
											<?php echo $value; ?>

										<?php else: ?>
											<?php echo e($value); ?>

										<?php endif; ?>
									<?php endif; ?>
								</td>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<td class="text-right" nowrap>
								<?php if ($__env->exists('page.office.' . $model_name . '.index-controls')) echo $__env->make('page.office.' . $model_name . '.index-controls', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

								<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $row)): ?>
									<?php echo $__env->make('control.office.table.edit', [
										'route'  => route("office.{$model_name}.edit", $id),
										'values' => $values ?? false,
										'footer' => $modal_footer,
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<?php endif; ?>

								<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $row)): ?>
									<?php echo $__env->make('control.office.table.delete', [
										'route' => route("office.{$model_name}.destroy", $id)
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								<?php endif; ?>
							</td>

						</tr>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="box-footer">
		

		<?php if($nested): ?>
			<?php echo e($dataset['rows']->appends([
					'sort' => $dataset['sort'],
					'direction' => $dataset['direction']
				])->fragment(str_plural(kebab_case($model_name)))->links()); ?>

		<?php else: ?>
			<?php echo e($dataset['rows']->appends(request()->all())->links()); ?>

		<?php endif; ?>
	</div>
<?php else: ?>
	<div class="box-footer">
		<?php echo $__env->make('partial.office.alert.absent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</div>
<?php endif; ?>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/plate/index.blade.php ENDPATH**/ ?>