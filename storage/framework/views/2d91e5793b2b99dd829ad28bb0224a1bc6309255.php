<?php $__env->startSection('content'); ?>
	<?php if(session('status')): ?>
		<div class="alert alert-success">
			<?php echo e(session('status')); ?>

		</div>
	<?php endif; ?>

	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="<?php echo e(url('/password/reset')); ?>">
			<?php echo e(csrf_field()); ?>


			<input type="hidden" name="token" value="<?php echo e($token); ?>">

			<div class="form-group row">
				<label for="email" class="col-md-3 col-xl-2 col-form-label">E-Mail</label>

				<div class="col-md-7 col-xl-8">
					<input id="email" type="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e($email or old('email')); ?>" required autofocus>

					<?php if($errors->has('email')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('email')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="password" class="col-md-3 col-xl-2 col-form-label">Пароль</label>

				<div class="col-md-7 col-xl-8">
					<input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" required>

					<?php if($errors->has('password')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('password')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="password-confirm" class="col-md-3 col-xl-2 col-form-label">Повтор пароля</label>
				<div class="col-md-7 col-xl-8">
					<input id="password-confirm" type="password" class="form-control<?php echo e($errors->has('password_confirmation') ? ' is-invalid' : ''); ?>" name="password_confirmation" required>

					<?php if($errors->has('password_confirmation')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('password_confirmation')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2 col-md-7 col-xl-8">
					<button type="submit" class="btn btn-primary">Сброс пароля</button>
				</div>
			</div>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/auth/passwords/reset.blade.php ENDPATH**/ ?>