<?php $__env->startSection('content'); ?>
	<div class="card-wrap" id="password-change">
		<h2 class="title">Изменение пароля</h2>
		
		<form action="<?php echo e(route('account.password.index')); ?>" method="post">
			<input type="hidden" name="type" value="password">
			<?php echo e(csrf_field()); ?>

			<div class="form-group row">
				<label for="old_password" class="col-md-3 col-form-label">Действующий пароль <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="password" id="old_password" name="old_password" class="form-control<?php echo e($errors->has('old_password') ? ' is-invalid' : ''); ?>">
					<?php if($errors->has('old_password')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('old_password')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-md-3 col-form-label">Новый пароль <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="password" id="password" name="password" class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>">
					<?php if($errors->has('password')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('password')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="password_confirmation" class="col-md-3 col-form-label">Повторите пароль <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="password" id="password_confirmation" name="password_confirmation<?php echo e($errors->has('password_confirmation') ? ' is-invalid' : ''); ?>" class="form-control">
					<?php if($errors->has('password_confirmation')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('password_confirmation')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="btn-account-row">
				<button type="submit" class="btn btn-primary pl-4 pr-4">Изменить пароль</button>
			</div>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/password/index.blade.php ENDPATH**/ ?>