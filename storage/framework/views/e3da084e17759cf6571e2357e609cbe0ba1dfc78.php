<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.brief.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $brief)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.brief.edit', [
						'brief' => $brief->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $brief,
				'model'		=> \App\Brief::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
						'user',
						'briefstatus',
						'picture',
						'picture_author',
						'announce',
						'content',
						'posted_at',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'briefcomments_count',
						'briefpictures_count',
						'brieftags_count',
					],
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Briefcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Briefpicture::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Brieftag::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Brieftournament::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $briefcomments,
				'model'		=> \App\Briefcomment::class,
				'fields'	=> [
					'user',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $briefpictures,
				'model'		=> \App\Briefpicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $brieftags,
				'model'		=> \App\Brieftag::class,
				'fields'	=> [
					'tag',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $brieftournaments,
				'model'		=> \App\Brieftournament::class,
				'fields'	=> [
					'tournament',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/brief/show.blade.php ENDPATH**/ ?>