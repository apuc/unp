<?php $__env->startSection('content'); ?>

	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="<?php echo e(url('/register')); ?>">
			<input type="hidden" name="id" value="<?php echo e(old('socialaccount_id')); ?>">
			<input type="hidden" name="social" value="<?php echo e(old('social')); ?>">
			<input type="hidden" name="name" value="<?php echo e(old('name')); ?>">
			<input type="hidden" name="avatar" value="<?php echo e(old('avatar')); ?>">

			<?php echo e(csrf_field()); ?>


			<div class="form-group row">
				<label for="name" class="col-md-3 col-xl-2 col-form-label"><?php echo app('translator')->get('field.site.login'); ?></label>

				<div class="col-md-7 col-xl-8">
					<input id="login" type="text" class="form-control<?php echo e($errors->has('login') ? ' is-invalid' : ''); ?>" name="login" value="<?php echo e(old('login')); ?>" required autofocus>

					<?php if($errors->has('login')): ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('login')); ?>

						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php if(is_null(old('email'))): ?>
				<div class="form-group row">
					<label for="email" class="col-md-3 col-xl-2 col-form-label"><?php echo app('translator')->get('field.site.email'); ?></label>

					<div class="col-md-7 col-xl-8">
						<input id="email" type="text" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>

						<?php if($errors->has('email')): ?>
							<div class="invalid-feedback">
								<?php echo e($errors->first('email')); ?>

							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php else: ?>
				<input type="hidden" name="email" value="<?php echo e(old('email')); ?>">
			<?php endif; ?>

			<div class="form-group row">
				<div class="col-md-7 col-xl-8 offset-md-3 offset-xl-2">
					<button type="submit" class="btn btn-primary">Войти</button>
				</div>
			</div>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/auth/social.blade.php ENDPATH**/ ?>