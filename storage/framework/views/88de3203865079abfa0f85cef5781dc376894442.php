<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.sitesection.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $sitesection)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.sitesection.edit', [
						'sitesection' => $sitesection->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $sitesection,
				'model'		=> \App\Sitesection::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'sitetexts_count',
						'bannerposts_count',
					],
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Sitetext::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Bannerpost::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $sitetexts,
				'model'		=> \App\Sitetext::class,
				'fields'	=> [
					'name',
					'slug',
					'title',
					'picture',
					'is_enabled',
					'position',
					'sitepictures_count',
				],
				'values'	=> [
					'sitesection_id' => $sitesection->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $bannerposts,
				'model'		=> \App\Bannerpost::class,
				'fields'	=> [
					'banner',
					'bannerplace',
					'margin',
					'started_at',
					'finished_at',
					'view_limit',
					'view_amount',
					'click_limit',
					'click_amount',
					'is_enabled',
					'is_debug',
				],
				'values'	=> [
					'sitesection_id' => $sitesection->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/sitesection/show.blade.php ENDPATH**/ ?>