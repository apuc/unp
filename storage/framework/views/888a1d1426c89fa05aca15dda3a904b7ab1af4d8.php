<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.tournament.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $tournament)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.tournament.edit', [
						'tournament' => $tournament->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $tournament,
				'model'		=> \App\Tournament::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
						'gender',
						'logo',
						'external_id',
						'tournamenttype',
						'position',
						'is_top',
					],
					'statistics' => [
						'seasons_count',
						'tournamentposts_count',
						'tournamentbriefs_count',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Season::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Posttournament::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Brieftournament::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $seasons,
				'model'		=> \App\Season::class,
				'fields'	=> [
					'name',
					'external_id',
					'stages_count',
				],
				'values'	=> [
					'tournament_id' => $tournament->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $posttournaments,
				'model'		=> \App\Posttournament::class,
				'fields'	=> [
					'post',
				],
				'values'	=> [
					'tournament_id' => $tournament->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $brieftournaments,
				'model'		=> \App\Brieftournament::class,
				'fields'	=> [
					'brief',
				],
				'values'	=> [
					'tournament_id' => $tournament->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/tournament/show.blade.php ENDPATH**/ ?>