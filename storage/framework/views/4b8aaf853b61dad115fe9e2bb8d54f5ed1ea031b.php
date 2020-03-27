<footer>
	<div class="footer">
		<div class="row">
			<div class="col-12 col-lg-3">
				<p class="footer-logo">SPORTLIGA.COM</p>
			</div>
			<div class="col-12 col-lg-9">
				<nav class="footer-nav nav">
        			<a class="nav-link" href="<?php echo e(route('site.brief.index')); ?>">Новости</a>
        			<a class="nav-link" href="<?php echo e(route('site.post.index')); ?>">Статьи</a>
        			<a class="nav-link" href="<?php echo e(route('site.forecast.index')); ?>">Прогнозы</a>
        			<a class="nav-link" href="<?php echo e(route('site.bookmaker.index')); ?>">Букмекеры</a>
        			<a class="nav-link" href="<?php echo e(route('site.deal.index')); ?>">Акции</a>
        			<a class="nav-link" href="<?php echo e(route('site.user.index')); ?>">Капперы</a>
        			<a class="nav-link" href="<?php echo e(route('site.match.index')); ?>">Матч-центр</a>
        		</nav>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-lg-3">
				<img src="<?php echo e(asset('images/site/gerb.png')); ?>" alt="Герб" class="heraldry">
			</div>
			<div class="col-12 col-lg-3 fcontacts">
				<div class="fphone">
					<?php echo Text::get($layout, 'contacts')->content; ?>

				</div>

				<?php if($socials->count()): ?>
					<div class="footer-social">
						<?php $__currentLoopData = $socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    						<a href="<?php echo e($social->community); ?>" target="_blank" rel="nofollow"><i class="<?php echo e($social->icon); ?>" aria-hidden="true"></i></a>
    					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="col-12 col-lg-6 ftext">
				<?php echo Text::get($layout, 'rules')->content; ?>

				<ul class="footer-list">
					
					
					<li><a href="<?php echo e(route('site.help.index')); ?>">Справка</a></li>
					
					<li><a href="<?php echo e(route('site.legal.show', ['document' => 'rules'])); ?>">Правила сайта</a></li>
				</ul>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-12 col-lg-3">
				<p class="copy">
					<span class="copy-icon d-none d-lg-block">&copy;</span>
    				<span class="d-inline-block d-lg-none">&copy;</span> 2018&ndash;2020<br>
    				SPORTLIGA.COM<br>
    				<span class="d-none d-lg-block">Все права защищены</span>
				</p>
			</div>
			<div class="col-12 col-lg-3">
				<p><span class="copy-dev">Создание сайта &copy; 2019&ndash;2020</span>
				<a target="_blank" href="https://rational-lab.com/">
					<span class="r-logo d-none d-lg-block"></span>
					<span class="d-block d-lg-none">RATIONAL LAB</span>
				</a></p>
				<hr class="d-block d-lg-none">
			</div>
			<div class="col-12 col-lg-3">
				<?php echo Text::get($layout, 'license')->content; ?>

			</div>
			<div class="col-12 col-lg-3">
				<?php echo Text::get($layout, 'advisory')->content; ?>

				<p class="d-block d-lg-block">
					<a href="<?php echo e(route('site.legal.index')); ?>">Правовая информация</a><br>
				</p>			
			</div>
		</div>
	</div>
</footer>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/footer.blade.php ENDPATH**/ ?>