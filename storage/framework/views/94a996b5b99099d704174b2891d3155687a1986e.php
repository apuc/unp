<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.commentstatus.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $commentstatus)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.commentstatus.edit', [
						'commentstatus' => $commentstatus->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $commentstatus,
				'model'		=> \App\Commentstatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'postcomments_count',
						'briefcomments_count',
						'forecastcomments_count',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Postcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Briefcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Forecastcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $postcomments,
				'model'		=> \App\Postcomment::class,
				'fields'	=> [
					'post',
					'user',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'commentstatus_id' => $commentstatus->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $briefcomments,
				'model'		=> \App\Briefcomment::class,
				'fields'	=> [
					'brief',
					'user',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'commentstatus_id' => $commentstatus->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $forecastcomments,
				'model'		=> \App\Forecastcomment::class,
				'fields'	=> [
					'forecast',
					'user',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'commentstatus_id' => $commentstatus->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/commentstatus/show.blade.php ENDPATH**/ ?>