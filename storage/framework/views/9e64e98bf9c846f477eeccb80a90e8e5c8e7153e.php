<!-- Main Content -->
<?php $__env->startSection('content'); ?>
	<?php if(session('status')): ?>
		<div class="alert alert-success">
			<?php echo e(session('status')); ?>

		</div>
	<?php endif; ?>

	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="<?php echo e(url('/password/email')); ?>">
			<?php echo e(csrf_field()); ?>


			<div class="form-group row">
				<label for="email" class="col-md-3 col-xl-2 col-form-label">E-Mail</label>

				<div class="col-md-7 col-xl-8">
					<input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>" required>

					<?php if($errors->has('email')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('email')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-7 col-xl-8 offset-md-3 offset-xl-2">
					<button type="submit" class="btn btn-primary">
						Отправить ссылку на сброс пароля
					</button>
				</div>
			</div>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>