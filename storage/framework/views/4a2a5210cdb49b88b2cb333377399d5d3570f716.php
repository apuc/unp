<?php $__env->startSection('content'); ?>
	<div class="card-wrap">
		<form class="mt-3" role="form" method="POST" action="<?php echo e(route('login')); ?>">
			<?php echo e(csrf_field()); ?>

			<div class="form-group row">
				<label for="email" class="col-md-3 col-xl-2 col-form-label">E-Mail</label>
				<div class="col-md-7 col-xl-8">
					<input type="text" id="email" name="email" value="<?php echo e(old('email')); ?>" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" placeholder="E-Mail">

					<?php if($errors->has('email')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('email')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-md-3 col-xl-2 col-form-label">Пароль</label>
				<div class="col-md-7 col-xl-8">
					<input type="password" id="password" name="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" placeholder="Пароль">

					<?php if($errors->has('password')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('password')); ?></div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2">&nbsp;</div>
				<div class="col-md-7 col-xl-8">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input" name="remember" id="remember" type="checkbox">
						<label class="custom-control-label" for="remember">Запомнить меня на этом компьютере</label>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2 col-md-7 col-xl-8">
					<button type="submit" class="btn btn-primary">Войти</button>
				</div>
			</div>
		</form>

		<div class="row">
			<div class="offset-md-3 offset-xl-2 col-md-7 col-xl-8">
				<div><a href="<?php echo e(url('/password/reset')); ?>">Забыли логин или пароль?</a></div>
				<div><a href="<?php echo e(url('/register')); ?>">Регистрация</a></div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/auth/login.blade.php ENDPATH**/ ?>