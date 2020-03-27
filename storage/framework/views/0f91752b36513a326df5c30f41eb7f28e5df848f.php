<?php $__env->startSection('content'); ?>
	<div class="card-wrap" id="social-authorization">
		<h2 class="title">НАСТРОЙКА АВТОРИЗАЦИИ ЧЕРЕЗ СОЦСЕТИ</h2>
		

		<div class="btn-account-row row-top">
			<a href="#" class="btn btn-primary pl-4 pr-4" data-toggle="modal" data-target="#win-logon"><i class="fa fa-plus" aria-hidden="true"></i> Добавить вход</a>
		</div>

		<?php if($errors->count()): ?>
			<div class="alert alert-danger">
				<strong><?php echo app('translator')->get('message.form.error'); ?></strong> <?php echo app('translator')->get('message.form.validation-failed'); ?>
				<ul class="mt-1 mb-0">
					<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li><?php echo e($error); ?></li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>
			</div>
		<?php endif; ?>

		<?php if($usersocials->count()): ?>
			<?php $__currentLoopData = $usersocials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usersocial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<div class="card settings-card">
					<div class="card-body">
						
						<div class="social-name"><a href="<?php echo e($usersocial->social->site); ?>"><?php echo e($usersocial->social->name); ?></div>
						<div class="social-del ml-auto">
							<a onclick="
								socialDestroy(
									'<?php echo e(route('account.social.destroy', ['social_id' => $usersocial->id])); ?>',
									'<?php echo e(csrf_token()); ?>',
									'<?php echo e(trans('message.site.social.destroy')); ?>'
								)
							" href="javascript: void(0);"><i class="fa fa-times" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	</div>

	<script>
		/**
		 * функция удаление соцсети
		 *
		 * @param  string route
		 * @param  string csrf
		 * @param  string message
		 * @param  boolean step
		 */

		function socialDestroy(route, csrf, message, step)
		{
			if (undefined === step) {
				if (confirm(message))
					socialDestroy(route, csrf, message, true);
			}

			else if (true === step)
				$.post(
					route,
					{
						'_token':  csrf,
						'_method': 'DELETE'
					},
					function(answer) {
						// перезагружаем страницу
						location.reload(true);
					}
				);
		}
	</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/social/index.blade.php ENDPATH**/ ?>