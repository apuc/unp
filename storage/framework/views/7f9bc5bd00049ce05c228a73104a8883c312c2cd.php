<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.post.show', $post->id),
		'dataset'   => $post,
		'model'     => \App\Post::class,
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
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/post/edit.blade.php ENDPATH**/ ?>