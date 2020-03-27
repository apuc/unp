<div class="row">
	<div class="col-lg-4 col-xl-3">
		<div class="box">
			<div class="box-header">
				<?php echo e($toolbar); ?>

			</div>

			<div class="box-body">
				<?php echo e($form); ?>

			</div>
		</div>
	</div>

	<div class="col-lg-8 col-xl-9">
		<?php if (! (empty($tabs))): ?>
			<div class="box nav-tabs-custom nav-flag-active">
				<ul class="nav nav-tabs">
					<?php echo e($tabs); ?>

				</ul>
				<script>
					$('.nav-flag-active li').eq(0).find('> a').addClass('active');
				</script>

				<div class="tab-content tab-flag-active">
					<?php echo e($panels); ?>


					<script>
						$('.tab-flag-active .tab-pane').eq(0).addClass('active');
					</script>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php if (! (empty($tabs))): ?>
	<?php echo $__env->make('partial.office.shell.modal-editor', [
		'action' => 'create'
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<?php echo $__env->make('partial.office.shell.modal-editor', [
	'action' => 'edit'
], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/screen/show.blade.php ENDPATH**/ ?>