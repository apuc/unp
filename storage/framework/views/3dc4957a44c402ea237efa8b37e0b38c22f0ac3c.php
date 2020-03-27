<?php $__env->startSection('content'); ?>
	<div class="card-wrap" id="personal-data">
		<h2 class="title">Изменение личных данных</h2>
		
		<form action="<?php echo e(route('account.personal.index')); ?>" method="post" enctype="multipart/form-data">
			<input type="hidden" name="type" value="contacts">
			<?php echo e(csrf_field()); ?>

			<div class="form-group row">
				<label for="name" class="col-md-3 col-form-label">Имя</label>
				<div class="col-md-9">
					<input name="name" type="text" id="name" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('name') ?? Auth::user()->name); ?>">
					<?php if($errors->has('name')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('name')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="login" class="col-md-3 col-form-label">Логин <span class="red">*</span></label>
				<div class="col-md-9">
					<input name="login" type="text" id="login" class="form-control<?php echo e($errors->has('login') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('login') ?? Auth::user()->login); ?>">
					<?php if($errors->has('login')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('login')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="email" class="col-md-3 col-form-label">E-mail <span class="red">*</span></label>
				<div class="col-md-9">
					<input name="email" type="email" id="email" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('email') ?? Auth::user()->email); ?>">
					<?php if($errors->has('email')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('email')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<label for="phone" class="col-md-3 col-form-label">Телефон</label>
				<div class="col-md-9">
					<input name="phone" type="phone" id="phone" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('phone') ?? Auth::user()->phone); ?>">
					<?php if($errors->has('phone')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('phone')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3 col-form-label">Аватар</label>
				<div class="col-md-9 d-flex">
					<img src="<?php echo e(asset('preview/80/80/storage/users/' . Auth::user()->avatar)); ?>" alt="<?php echo e(Auth::user()->nickname); ?>">
					<div class="avatar-act">
						<label for="avatar" class="btn btn-light">Загрузить изображение</label>
						<input type="file" hidden id="avatar" name="avatar">
						<?php if(!is_null(Auth::user()->avatar)): ?>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" name="avatar_clean" id="del">
								<label class="custom-control-label" for="del">Удалить</label>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="form-group row">
				<label for="about" class="col-md-3 col-form-label">О себе</label>
				<div class="col-md-9">
					<textarea name="about" id="about" rows="5" class="form-control<?php echo e($errors->has('about') ? ' is-invalid' : ''); ?>"><?php echo e(old('about') ?? Auth::user()->about); ?></textarea>
					<?php if($errors->has('about')): ?>
						<div class="invalid-feedback"><?php echo e($errors->first('about')); ?></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="btn-account-row">
				<button type="submit" class="btn btn-primary pl-4 pr-4">Сохранить данные</button>
			</div>
		</form>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/personal/index.blade.php ENDPATH**/ ?>