<?php $__env->startSection('content'); ?>
	<div class="card-wrap" id="setting-notifications">
		<h2 class="title">НАСТРОЙКА УВЕДОМЛЕНИЙ</h2>
		

		<div class="row">
			<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
				<div class="notification-setting">
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="1">
						<label class="custom-control-label" for="1">Получать новости</label>
					</div>
					<div class="custom-control custom-checkbox">
						<input type="checkbox" class="custom-control-input" id="2" checked>
						<label class="custom-control-label" for="2">Уведомлять на&nbsp;E-mail о&nbsp;результатах Вашего прогноза <span class="red">*</span></label>
					</div>
				</div>
			</div>
		</div>
		<div class="btn-account-row">
			<a href="#" class="btn btn-primary pl-4 pr-4">Сохранить настройки</a>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/notice/index.blade.php ENDPATH**/ ?>