<?php $__env->startSection('content'); ?>
	<?php $__env->startComponent('control.office.screen.show'); ?>
		<?php $__env->slot('toolbar'); ?>
			<?php echo $__env->make('control.office.toolbar.back', [
				'url' => route('office.issue.index')
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $issue)): ?>
				<?php echo $__env->make('control.office.toolbar.edit', [
					'url' => route('office.issue.edit', [
						'issue' => $issue->id
					])
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endif; ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('form'); ?>
			<?php echo $__env->make('control.office.plate.show', [
				'dataset'	=> $issue,
				'model'		=> \App\Issue::class,
				'groups'	=> [
					'properties' => [
						'id',
						'posted_at',
						'user',
						'issuetype',
						'issuestatus',
						'author',
						'email',
					]
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('tabs'); ?>
			<?php echo $__env->make('control.office.plate.nested-tab', [
				'model' => \App\Answer::class,
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

		<?php $__env->slot('panels'); ?>
			<?php echo $__env->make('control.office.plate.nested-index', [
				'dataset' 	=> $answers,
				'model'		=> \App\Answer::class,
				'fields'	=> [
					'id',
					'posted_at',
					'user',
					'message',
				],
				'values'	=> [
					'issue_id' => $issue->id
				],
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php $__env->endSlot(); ?>

	<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.office.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/issue/show.blade.php ENDPATH**/ ?>