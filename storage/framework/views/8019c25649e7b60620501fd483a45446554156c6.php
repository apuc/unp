<?php $__env->startSection('content'); ?>
	<div class="b-filter-top">
		<div class="b-filter-top__sport-nav">
			<ul class="b-filter-top__sport-main-list">
				<li class="b-filter-top__sport-main-item">
					<a href="javascript: void(0);" class="nav-link active">Сайт</a>
				</li>
				<li class="b-filter-top__sport-main-item">
					<a href="<?php echo e(route('login.vkontakte')); ?>" class="nav-link">Вконтакте</a>
				</li>
				<li class="b-filter-top__sport-main-item">
					<a href="<?php echo e(route('login.facebook')); ?>" class="nav-link">Facebook</a>
				</li>
				<li class="b-filter-top__sport-main-item">
					<a href="<?php echo e(route('login.google')); ?>" class="nav-link">Google</a>
				</li>
			</ul>
		</div>
	</div>

	<div class="card-wrap">
		<form id="reg" class="mt-3" role="form" method="POST" action="<?php echo e(url('/register')); ?>" onsubmit="return false;">
			<?php echo e(csrf_field()); ?>


			<div class="form-group row">
				<label for="login" class="col-md-3 col-xl-2 col-form-label"><?php echo app('translator')->get('field.site.login'); ?></label>
				<div class="col-md-7 col-xl-8">
					<input id="login" type="text" class="form-control<?php echo e($errors->has('login') ? ' is-invalid' : ''); ?>" name="login" value="<?php echo e(old('login')); ?>" required autofocus>

					<?php if($errors->has('login')): ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('login')); ?>

						</div>
					<?php endif; ?>
				</div>
			</div>

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

			<div class="form-group row">
				<label for="password" class="col-md-3 col-xl-2 col-form-label"><?php echo app('translator')->get('field.site.password'); ?></label>
				<div class="col-md-7 col-xl-8">
					<input id="password" type="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>" name="password" value="" required>

					<?php if($errors->has('password')): ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('password')); ?>

						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="password_confirmation" class="col-md-3 col-xl-2 col-form-label"><?php echo app('translator')->get('field.site.password_confirmation'); ?></label>
				<div class="col-md-7 col-xl-8">
					<input id="password_confirmation" type="password" class="form-control<?php echo e($errors->has('password_confirmation') ? ' is-invalid' : ''); ?>" name="password_confirmation" value="" required>

					<?php if($errors->has('password_confirmation')): ?>
						<div class="invalid-feedback">
							<?php echo e($errors->first('password_confirmation')); ?>

						</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="form-group row">
				<div class="offset-md-3 offset-xl-2">&nbsp;</div>
				<div class="col-md-7 col-xl-8">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input policy-check" id="reg-policy" type="checkbox">
						<label class="custom-control-label" for="reg-policy">Я согласен на обработку <a href="<?php echo e(url('/legal/privacy')); ?>">персональных данных</a></label>
						<div class="invalid-feedback policy-error">Вы не дали согласие на обработку персональных данных</div>
					</div>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-7 col-xl-8 offset-md-3 offset-xl-2">
					<button
						type="submit"
						class="btn btn-primary"
						onclick="
							ssCheckPolicy(event, $('#reg'), function () {
								$('#reg').attr('onsubmit', '');
								$('#reg').submit();
							});
						"
					>
						<?php echo app('translator')->get('button.register'); ?>
					</button>
				</div>
			</div>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/auth/register.blade.php ENDPATH**/ ?>