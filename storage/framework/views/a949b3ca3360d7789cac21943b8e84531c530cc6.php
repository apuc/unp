<?php $__env->startSection('content'); ?>
	<?php echo $__env->make('control.office.plate.edit', [
		'action'    => route('office.notice.show', $notice->id),
		'dataset'   => $notice,
		'model'     => \App\Notice::class,
		'groups'	=> [
			'properties' => [
				'posted_at',
				'event',
				'noticetype',
				'noticestatus',
				'user',
				'message',
			],
		],
	], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.office.blank', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/notice/edit.blade.php ENDPATH**/ ?>