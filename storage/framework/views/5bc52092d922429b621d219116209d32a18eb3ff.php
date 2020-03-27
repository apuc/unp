<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.sport.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $sport)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.sport.edit', [
						'sport' => $sport->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $sport,
				'model'		=> \App\Sport::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'icon',
						'has_odds',
						'position',
						'external_id',
						'external_name',
						'is_enabled',
					],
					'statistics' => [
						'teams_count',
						'tournamenttypes_count',
						'tournaments_count',
						'posts_count',
						'briefs_count',
						'forecasts_count',
					],
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Team::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Tournamenttype::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Tournament::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Post::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Brief::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Forecast::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $teams,
				'model'		=> \App\Team::class,
				'fields'	=> [
					'name',
					'country',
					'gender',
					'logo',
					'external_id',
					'participants_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $tournamenttypes,
				'model'		=> \App\Tournamenttype::class,
				'fields'	=> [
					'name',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $tournaments,
				'model'		=> \App\Tournament::class,
				'fields'	=> [
					'gender',
					'tournamenttype',
					'name',
					'logo',
					'external_id',
					'position',
					'is_top',
					'seasons_count',
					'tournamentposts_count',
					'tournamentbriefs_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $posts,
				'model'		=> \App\Post::class,
				'fields'	=> [
					'name',
					'user',
					'poststatus',
					'picture',
					'posted_at',
					'postcomments_count',
					'postpictures_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $briefs,
				'model'		=> \App\Brief::class,
				'fields'	=> [
					'name',
					'user',
					'briefstatus',
					'picture',
					'posted_at',
					'briefcomments_count',
					'briefpictures_count',
				],
				'values'	=> [
					'sport_id' => $sport->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $forecasts,
				'model'		=> \App\Forecast::class,
				'fields'	=> [
					'outcome',
					'bookmaker',
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
					'sport_id' => $sport->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/sport/show.blade.php ENDPATH**/ ?>