<?php $__env->startSection('content'); ?>
	<div class="card-wrap mt-3">

		<?php echo $__env->make('partial.site.panel.deal.sort', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div data-ss-pn-content id="view-cards-box">
			<?php if($deals['rows']->count()): ?>
				<div class="cards-box <?php echo e($deals['view'] == 0 ? 'cards_tile' : 'cards_list'); ?>">
					<div class="row">
						<?php $__currentLoopData = $deals['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-12 col-md-6 col-lg-4">
								<?php echo $__env->make('card.site.deal.normal', [
									'deal' => $deal,
								], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			<?php endif; ?>

			<div <?php echo (!$deals['rows']->hasMorePages()) ? 'style="display: none"' : ''; ?> class="btn-more-box">
				<input
					data-ss-pn-parameter="page"
					type="hidden"
					value="<?php echo e($deals['rows']->currentPage()); ?>"
				>
				<a
					data-ss-pn-submit="click"
					data-ss-pn-page-value="<?php echo e($deals['rows']->currentPage() + 1); ?>"
					href="javascript: void(0);"
					class="btn btn-more"
				>Ещё акции</a>
			</div>
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
	<?php if(filled($document = Text::get($sitesection, 'top'))): ?>
		<section class="text-top">
			<?php echo $document->content; ?>

		</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.deals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
	<?php if(filled($document = Text::get($sitesection, 'bottom'))): ?>
		<section class="text-bottom">
			<?php echo $document->content; ?>

		</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/deal/index.blade.php ENDPATH**/ ?>