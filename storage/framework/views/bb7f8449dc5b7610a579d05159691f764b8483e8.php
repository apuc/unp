<?php $__env->startSection('content'); ?>

	<?php echo $__env->make('partial.site.panel.forecast.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php echo $__env->make('partial.site.panel.forecast.sort', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

	<div data-ss-pn-content>
		<?php if($forecasts['rows']->count()): ?>
			<div class="cards-box <?php echo e($forecasts['view'] == 0 ? 'cards_tile' : 'cards_list'); ?>">
				<div class="row">
					<?php $__currentLoopData = $forecasts['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div class="col-12 col-md-4">
							<?php echo $__env->make('card.site.forecast.normal', [
								'forecast' => $forecast,
							], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		<?php endif; ?>

		<div <?php echo (!$forecasts['rows']->hasMorePages()) ? 'style="display: none"' : ''; ?> class="btn-more-box">
			<input
				data-ss-pn-parameter="page"
				type="hidden"
				value="<?php echo e($forecasts['rows']->currentPage()); ?>"
			>
			<a
				data-ss-pn-submit="click"
				data-ss-pn-page-value="<?php echo e($forecasts['rows']->currentPage() + 1); ?>"
				href="javascript: void(0);"
				class="btn btn-more"
			>Ещё прогнозы</a>
		</div>
	</div>

	<script>
		$(document).ready(function () {
			ssPN().bind('ss.pn.content.update', function (e, data) {
				var page = $("*[data-ss-pn-parameter='page']").val();

				// обновляем контент
				data = $('<div>' + data + '</div>');

				// если первая страница
				if (page == 1) {
					// пересобираем блок целеком
					$("*[data-ss-pn-content]").html(
						data.find("*[data-ss-pn-content]").html()
					);
				}

				// если остальные
				else {
					// дополняем блоки
					$('.cards-box .row > div:last-child').after(
						data.find('.cards-box .row').html()
					);

					// заменяем кнопку
					if (data.find("*[data-ss-pn-content]").find('.btn-more-box').css('display') != 'none')
						$("*[data-ss-pn-content]").find('.btn-more-box').html(
							data.find("*[data-ss-pn-content]").find('.btn-more-box').html()
						);
					else
						$("*[data-ss-pn-content]").find('.btn-more-box').css('display', 'none');
				}
			});
		});
	</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top'); ?>
	<section class="text-top">
		<div class="row">
			<div class="text-top__btn">
				<a href="<?php echo e(route('account.forecast.create')); ?>" class="btn btn-primary btn-lg mb-3 mb-lg-0"><i class="fa fa-plus" aria-hidden="true"></i> Сделать прогноз</a>
			</div>
			<div class="col">
				<?php echo optional(Text::get($sitesection, 'top'))->content; ?>

			</div>
		 </div>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.forecasts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
	<?php if(filled($document = Text::get($sitesection, 'bottom'))): ?>
	   	<section class="text-bottom">
			<?php echo $document->content; ?>

	   	</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/forecast/index.blade.php ENDPATH**/ ?>