<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.post.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $post)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.post.edit', [
						'post' => $post->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $post,
				'model'		=> \App\Post::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
						'user',
						'poststatus',
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
						'postcomments_count',
						'postpictures_count',
						'posttags_count',
					],
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Postcomment::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Postpicture::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Posttag::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Posttournament::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $postcomments,
				'model'		=> \App\Postcomment::class,
				'fields'	=> [
					'user',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $postpictures,
				'model'		=> \App\Postpicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $posttags,
				'model'		=> \App\Posttag::class,
				'fields'	=> [
					'tag',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $posttournaments,
				'model'		=> \App\Posttournament::class,
				'fields'	=> [
					'tournament',
				],
				'values'	=> [
					'post_id' => $post->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>
	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/post/show.blade.php ENDPATH**/ ?>