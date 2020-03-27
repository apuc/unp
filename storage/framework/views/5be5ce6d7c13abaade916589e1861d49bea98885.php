<?php $__env->startSection('content'); ?>
	<div class="card-wrap">
		<div id="view-cards-box">
			<div class="sorting d-flex justify-content-end">
				<div class="sort-box mr-auto">
					<span class="sort-box__title">Сортировка</span>
					<div class="sort-box__select">
						<select class="form-control form-control-sm">
							<option selected="selected" value="">Новые</option>
							<option value="">Комментируемые</option>
							<option value="">Цитируемые</option>
						</select>
					</div>
				</div>

				<div class="product-view">
					<span class="product-view__title">Вид</span>
					<span class="product-view__item view-as-grid selected" title="Плитка"><i></i></span>
					<span class="product-view__item view-as-list" title="Список"><i></i></span>
				</div>
			</div>

			<?php if($briefs->count()): ?>
				<div class="cards-box cards_tile">
					<div class="row">
						<?php $__currentLoopData = $briefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="col-12 col-md-6 col-lg-4">
								<?php echo $__env->make('card.site.brief.own', [
									'brief' => $brief,
								], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				</div>
			<?php endif; ?>

			<div class="btn-more-box">
				<a href="#" class="btn btn-more">Ещё новости</a>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('top'); ?>
	<section class="text-top">
		<div class="row">
			<div class="col-12 col-lg-9">
				&nbsp;
			</div>
			<div class="col-12 col-lg-3 text-center align-self-end">
				<a href="<?php echo e(route('account.brief.create')); ?>" class="btn btn-primary btn-lg"><i class="fa fa-plus" aria-hidden="true"></i> опубликовать новость</a>
			</div>
		 </div>
	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.account', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/account/brief/index.blade.php ENDPATH**/ ?>