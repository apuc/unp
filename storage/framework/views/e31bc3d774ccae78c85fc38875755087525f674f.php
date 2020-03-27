<?php
	$entity = modelEntity($model);
	$record = $entity::create($dataset, $event);
?>

<?php echo $__env->make('control.office.form.errors', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $fields): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php echo $__env->make('control.office.form.group', [
		'field' => $group
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<?php
			$control	= $record->property($field, 'control');
			$readonly	= $record->property($field, 'readonly');

			$value		= $record->property($field, 'value');
			$collabel	= filled($collabel	= $record->property($field, 'collabel'))	? $collabel	: 2;
			$colinput	= filled($colinput	= $record->property($field, 'colinput'))	? $colinput	: 10;
			$required	= filled($required	= $record->property($field, 'required'))	? $required	: false;
			$mask		= filled($mask		= $record->property($field, 'mask'))		? $mask		: null;
			$default	= filled($default	= $record->property($field, 'default'))		? $default	: false;
		?>
		<?php if($control == 'text'): ?>
			<?php echo $__env->make('control.office.form.input-text', [
				'field'		=> $field,
				'value'		=> $value,
				'readonly'	=> $readonly ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'mask'		=> $mask,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'textarea'): ?>
			<?php echo $__env->make('control.office.form.input-textarea', [
				'field'		=> $field,
				'value'		=> $value,
				'readonly'	=> $readonly ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'mask'		=> $mask,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'htmleditor'): ?>
			<?php echo $__env->make('control.office.form.input-html', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'select'): ?>
			<?php echo $__env->make('control.office.form.input-select', [
				'field'		=> $field,
				'id'		=> $record->property($field, 'id'),
				'value'		=> $value,
				'options'	=> $record->property($field, 'options'),
				'lookup'	=> $record->property($field, 'lookup'),
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'search'): ?>
			<?php echo $__env->make('control.office.form.input-search', [
				'field'		=> $field,
				'id'		=> $event == 'edit' ? $record->property($field, 'id') : null,
				'value'		=> $value,
				'search'	=> $record->property($field, 'search'),
				'create'	=> $record->property($field, 'create') ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'checkbox'): ?>
			<?php echo $__env->make('control.office.form.input-checkbox', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'password'): ?>
			<?php echo $__env->make('control.office.form.input-password', [
				'field'		=> $field,
				'value'		=> $value,
				'readonly'	=> $readonly ?? null,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'picture'): ?>
			<?php echo $__env->make('control.office.form.input-picture', [
				'field'		=> $field,
				'value'		=> $record->record,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'required'	=> $required,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'attachment'): ?>
			<?php echo $__env->make('control.office.form.input-attachment', [
				'field'		=> $field,
				'value'		=> $record->record,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
				'required'	=> $required,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'date'): ?>
			<?php echo $__env->make('control.office.form.input-date', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'datetime'): ?>
			<?php echo $__env->make('control.office.form.input-datetime', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'daterange'): ?>
			<?php echo $__env->make('control.office.form.input-daterange', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php elseif($control == 'datetimerange'): ?>
			<?php echo $__env->make('control.office.form.input-datetimerange', [
				'field'		=> $field,
				'value'		=> $value,
				'collabel'	=> $collabel,
				'colinput'	=> $colinput,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/plate/form.blade.php ENDPATH**/ ?>