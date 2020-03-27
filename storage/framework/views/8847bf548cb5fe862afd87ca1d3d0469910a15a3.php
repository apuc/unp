<?php $__env->startSection('content'); ?>
	<!-- Таблица матчей -->
	<div class="mb-5">

		<?php echo $__env->make('partial.site.panel.match.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div data-ss-pn-content data-ss-pn-return-datatype="json" data-ss-pn-url="<?php echo e(route('site.match.ajax')); ?>" id="view-cards-box">
			<div id="ss-vue-filter-load-list">
				<p class="mt-3 text-center">Загрузка...</p>
			</div>
		</div>

		<div id="ss-vue-filter-json" hidden><?php echo collect([
			'dataset'		=> $dataset,
			'parameters'	=> [
				'days'			=> !is_null(Matchparameter::topical('day'))			? Matchparameter::topical('day')		->getParameters()['values']->toArray() : [],
				'sports'		=> !is_null(Matchparameter::topical('sport'))		? Matchparameter::topical('sport')		->getParameters()['values']->toArray() : [],
				'statuses'		=> !is_null(Matchparameter::topical('status'))		? Matchparameter::topical('status')		->getParameters()['values']->toArray() : [],
				'tournaments'	=> !is_null(Matchparameter::topical('tournament'))	? Matchparameter::topical('tournament')	->getParameters()['values']->toArray() : [],
			],
		])->toJson(); ?></div>

		<div id="ss-vue-filter-current-day" hidden><?php echo e(Matchparameter::get('day', 'false')); ?></div>
		<div id="ss-vue-filter-current-sport" hidden><?php echo e(Matchparameter::get('sport', 'false')); ?></div>
		<div id="ss-vue-filter-current-tournament" hidden><?php echo e(Matchparameter::get('tournament', 'false')); ?></div>
		<div id="ss-vue-filter-current-status" hidden><?php echo e(Matchparameter::get('status', 'false')); ?></div>

		<script>
			$(document).ready(function () {
				ssVueFilter({
					data:		$('#ss-vue-filter-json').text(),
					blocks:		['list', 'top', 'left'],
					components:	'<?php echo e(route('site.match.load')); ?>',
				}).load();

				/**
				 * перезагрузка контента
				 *
				 */

				ssPN().bind('ss.pn.content.update', function (e, data) {
					$('body').trigger('ss.pn.matches.update', [data]);
				});

				/**
				 *
				 *
				 */

				$('body').bind('ss.pn.submit-sport', function (e, box) {
					// удаляем выбранный турнир
					$("input[data-ss-pn-parameter='tournament']").remove();
					$('#param-tournament > a input').prop('checked', false);

					// удаляем статус
					$("input[data-ss-pn-parameter='status']").remove();
					$('#param-status select option').prop('selected', false);
				});

				/**
				 *
				 *
				 */

				$('body').bind('ss.pn.submit-day', function (e, box) {
					// удаляем выбранный турнир
					$("input[data-ss-pn-parameter='tournament']").remove();
					$('#param-tournament > a input').prop('checked', false);

					// удаляем спорт
					$("*[data-ss-pn-parameter='sport']").remove();

					// удаляем статус
					$("input[data-ss-pn-parameter='status']").remove();
					$('#param-status select option').prop('selected', false);
				});
			});
		</script>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top'); ?>
	<?php if(filled($document = Text::get($sitesection, 'top'))): ?>
	   	<section class="text-top">
			<?php echo $document->content; ?>

	   	</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.matches', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
	<?php if(filled($document = Text::get($sitesection, 'bottom'))): ?>
	   	<section class="text-bottom">
			<?php echo $document->content; ?>

	   	</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/match/index.blade.php ENDPATH**/ ?>