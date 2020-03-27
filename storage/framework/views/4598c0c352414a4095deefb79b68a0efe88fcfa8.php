<?php $__env->startSection('content'); ?>
	<div class="card-wrap">
		<div class="alert alert-danger">
			<strong><?php echo app('translator')->get('message.form.error'); ?></strong> <?php echo app('translator')->get('message.form.validation-failed'); ?>
		</div>

		<div class="row">
			<div class="col">
				<?php if($social == 'vk'): ?>
					<a class="btn btn-primary btn-lg" href="<?php echo e(route('login.vkontakte')); ?>">Повторить попытку</a>
				<?php elseif($social == 'facebook'): ?>
					<a class="btn btn-primary btn-lg" href="<?php echo e(route('login.facebook')); ?>">Повторить попытку</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/auth/error.blade.php ENDPATH**/ ?>