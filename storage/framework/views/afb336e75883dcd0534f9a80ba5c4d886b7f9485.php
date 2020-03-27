<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.bookmaker.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $bookmaker)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.bookmaker.edit', [
						'bookmaker' => $bookmaker->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $bookmaker,
				'model'		=> \App\Bookmaker::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'logo',
						'cover',
						'bonus',
						'announce',
						'description',
						'site',
						'phone',
						'email',
						'address',
						'external_id',
						'position',
						'is_enabled',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'forecasts_count',
						'offers_count',
						'deals_count',
						'bookmakertexts_count',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Offer::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Deal::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Bookmakertext::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'sport',
					'outcome',
					'match',
					'started_at',
					'user',
					'forecaststatus',
					'rate',
					'bet',
					'posted_at',
					'description',
					'forecastcomments_count',
					'forecastpictures_count',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $offers,
				'model'		=> \App\Offer::class,
				'fields'	=> [
					'outcome',
					'odds_current',
					'odds_old',
					'coupon',
					'has_offers',
					'external_id',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $deals,
				'model'		=> \App\Deal::class,
				'fields'	=> [
					'name',
					'dealtype',
					'cover',
					'started_at',
					'finished_at',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $bookmakertexts,
				'model'		=> \App\Bookmakertext::class,
				'fields'	=> [
					'name',
					'slug',
					'picture',
					'is_enabled',
					'bookmakerpictures_count',
				],
				'values'	=> [
					'bookmaker_id' => $bookmaker->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/bookmaker/show.blade.php ENDPATH**/ ?>