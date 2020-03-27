<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.country.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $country)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.country.edit', [
						'country' => $country->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $country,
				'model'		=> \App\Country::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'flag',
						'is_enabled',
					],
					'external' => [
						'external_id',
						'external_name',
					],
					'statistics' => [
						'teams_count',
						'stages_count',
					],
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Team::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Stage::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $teams,
				'model'		=> \App\Team::class,
				'fields'	=> [
					'name',
					'sport',
					'gender',
					'logo',
					'external_id',
				],
				'values'	=> [
					'country_id' => $country->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $stages,
				'model'		=> \App\Stage::class,
				'fields'	=> [
					'name',
					'season',
					'gender',
					'external_id',
					'matches_count',
				],
				'values'	=> [
					'country_id' => $country->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/country/show.blade.php ENDPATH**/ ?>