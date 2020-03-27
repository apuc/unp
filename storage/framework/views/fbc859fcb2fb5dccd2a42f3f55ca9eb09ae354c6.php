<?php $__env->startSection('content'); ?>

	<div class="card-wrap">

		<?php echo $__env->make('partial.site.panel.post.filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php echo $__env->make('partial.site.panel.post.sort', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		<div data-ss-pn-content id="view-cards-box">
			<?php if($posts['rows']->count()): ?>
				<div class="cards-box <?php echo e($posts['view'] == 0 ? 'cards_tile' : 'cards_list'); ?>">
					<div class="row">
						<?php $__currentLoopData = $posts['rows']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-12 col-md-6 col-lg-4">
								<?php echo $__env->make('card.site.post.normal', [
									'post' => $post,
								], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			<?php endif; ?>

			<div <?php echo (!$posts['rows']->hasMorePages()) ? 'style="display: none"' : ''; ?> class="btn-more-box">
				<input
					data-ss-pn-parameter="page"
					type="hidden"
					value="<?php echo e($posts['rows']->currentPage()); ?>"
				>
				<a
					data-ss-pn-submit="click"
					data-ss-pn-page-value="<?php echo e($posts['rows']->currentPage() + 1); ?>"
					href="javascript: void(0);"
					class="btn btn-more"
				>Ещё статьи</a>
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
	<section class="text-top">
		<div class="row">
			<div class="text-top__btn">
				<a href="<?php echo e(route('account.post.create')); ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus" aria-hidden="true"></i> опубликовать статью</a>
			</div>
			<div class="col">
				<?php echo optional(Text::get($sitesection, 'top'))->content; ?>

			</div>
		 </div>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.posts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('bottom'); ?>
	<?php if(filled($document = Text::get($sitesection, 'bottom'))): ?>
	   	<section class="text-bottom">
			<?php echo $document->content; ?>

	   	</section>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/post/index.blade.php ENDPATH**/ ?>