<ul class="submenu">
	

	

	<?php echo $__env->make('control.site.menu.item', [
		'route'		=> 'site.legal.index',
		'label'		=> 'Правовая информация',
		'current'	=> $current,
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<?php echo $__env->make('control.site.menu.item', [
		'route'		=> 'site.help.index',
		'label'		=> 'Справка',
		'current'	=> $current,
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	
</ul>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/sidebar/info.blade.php ENDPATH**/ ?>