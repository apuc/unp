<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.create', [
		'action'    => route('office.issue.index'),
		'dataset'   => $issue,
		'model'     => \App\Issue::class,
		'groups'	=> [
			'properties' => [
				'posted_at',
				'user',
				'issuetype',
				'issuestatus',
				'author',
				'email',
				'message',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/issue/create.blade.php ENDPATH**/ ?>