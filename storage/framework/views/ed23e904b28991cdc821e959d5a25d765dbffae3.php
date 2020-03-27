<?php
    $title = trans('page.office.site.index')
?>

<?php $__env->startSection('content'); ?>
	<div class="card-deck dashboart">
		
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/site/index.blade.php ENDPATH**/ ?>