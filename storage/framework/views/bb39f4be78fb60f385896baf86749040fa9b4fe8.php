<?php $__env->startSection('columns'); ?>
	<section class="home-postings">
		<div class="row">
			<div class="col-12 col-lg-6">
				<?php if($posts->count()): ?>
					<div class="card-wrap">
						<h2 class="title">Статьи</h2>

						<div class="cards_tile">
							<?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php echo $__env->make('card.site.post.home', [
									'post' => $post,
								], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
						<div class="btn-more-box">
							<a href="<?php echo e(route('site.post.index')); ?>" class="btn btn-more">Все статьи</a>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<div class="col-12 col-lg-6">
				<?php if($briefs->count()): ?>
					<div class="card-wrap">
						<h2 class="title">Новости</h2>

						<div class="home-briefs">
							<?php $__currentLoopData = $briefs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brief): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<?php echo $__env->make('card.site.brief.home', [
									'brief' => $brief,
								], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
						<div class="btn-more-box">
							<a href="<?php echo e(route('site.brief.index')); ?>" class="btn btn-more">Все новости</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php if($forecasts->count()): ?>
		<section class="home-forecasts">
			<div class="row">
				<div class="col-12 col-lg-9">

						<div class="card-wrap">
							<h2 class="title">Новые прогнозы</h2>

							<?php $__currentLoopData = $forecasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="cards_list">
									<?php echo $__env->make('card.site.forecast.normal', [
										'forecast' => $forecast
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<?php $__currentLoopData = $forecasts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $forecast): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        						<div class="cards_tile">
									<?php echo $__env->make('card.site.forecast.normal', [
										'forecast' => $forecast
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        						</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<div class="btn-more-box">
								<a href="<?php echo e(route('site.forecast.index')); ?>" class="btn btn-more">Все прогнозы</a>
							</div>
						</div>
				</div>

				<?php if($users->count()): ?>
					<div class="col-12 col-lg-3">
						<div class="card-wrap">
							<h2 class="title">Лучшие капперы</h2>

							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="user-cards_list">
									<?php echo $__env->make('card.site.user.home', [
										'user' => $user,
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="cards_tile">
									<?php echo $__env->make('card.site.user.normal', [
										'user' => $user,
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<div class="btn-more-box">
								<a href="<?php echo e(route('site.user.index')); ?>" class="btn btn-more">Все капперы</a>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if($bookmakers->count()): ?>
		<section class="home-bookmakers">
			<div class="row">
				<div class="col-12 col-lg-9">
					<div class="card-wrap">
						<h2 class="title">Лучшие букмекеры</h2>

						<?php $__currentLoopData = $bookmakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="cards_list">
								<?php echo $__env->make('card.site.bookmaker.normal', [
									'bookmaker' => $bookmaker
								], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						<?php $__currentLoopData = $bookmakers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<div class="cards_tile">
								<?php echo $__env->make('card.site.bookmaker.normal', [
									'bookmaker' => $bookmaker
								], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

						<div class="btn-more-box">
							<a href="<?php echo e(route('site.bookmaker.index')); ?>" class="btn btn-more">Все букмекеры</a>
						</div>
					</div>
				</div>
				<div class="col-12 col-lg-3">
					<div class="card-wrap home-deals">
						<h2 class="title">Лучшие акции</h2>

						<?php if($deals->count()): ?>

							<?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="cards_tile">
									<?php echo $__env->make('card.site.deal.normal', [
										'deal' => $deal
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<?php $__currentLoopData = $deals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="cards_list">
									<?php echo $__env->make('card.site.deal.normal', [
										'deal' => $deal
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						<?php endif; ?>

						<div class="btn-more-box">
							<a href="<?php echo e(route('site.deal.index')); ?>" class="btn btn-more">Все акции</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php if($matches->count()): ?>
		<section class="home-events">
			<div class="row">

				<div class="col-12 col-lg-9">
					<div class="card-wrap">
						<h2 class="title">События сегодня</h2>

							<?php $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="cards_list">
									<?php echo $__env->make('card.site.match.home', [
										'match' => $match,
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<!-- для мобил -->
							<?php $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="cards_tile">
									<?php echo $__env->make('card.site.match.home', [
										'match' => $match,
									], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

							<div class="btn-more-box">
								<a href="<?php echo e(route('site.match.index')); ?>" class="btn btn-more">Все события</a>
							</div>
					</div>
				</div>

				<div class="col-12 col-lg-3">
					<div class="card-wrap">
						<h2 class="title">Турниры сегодня</h2>

						<?php echo $__env->make('card.site.tournament.home', [
							'sports' => $sports
						], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

						<div class="btn-more-box">
							<a href="<?php echo e(route('site.match.index')); ?>" class="btn btn-more">Все турниры</a>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<section class="text-bottom">
		<?php echo $__env->make('partial.site.text', [
			'section' => $sitesection,
			'text' => 'bottom'
		], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</section>

	<div class="b-benefit__list">
		<?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php echo $__env->make('card.site.benefit.normal', [
				'benefit' => $benefit
			], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/home/index.blade.php ENDPATH**/ ?>