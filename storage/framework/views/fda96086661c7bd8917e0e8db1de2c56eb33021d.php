<a class="card bookmaker-card" href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug])); ?>">
	<div class="card-header">
		<span class="name"><object><a href="<?php echo e(route('site.bookmaker.index')); ?>">Букмекеры</a></object> / <object><a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug])); ?>"><?php echo e($bookmaker->name); ?></a></object></span>
		
	</div>
	<div class="card-body">
		<div class="bookmaker-header">
			<div class="bookmaker-logo">
				<object><a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug])); ?>"><img src="<?php echo e(asset('preview/512/223/storage/bookmakers/' . $bookmaker->logo)); ?>" alt="<?php echo e($bookmaker->name); ?>"></a></object>	
			</div>
			<div class="bookmaker-name"><object><a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug])); ?>"><?php echo e($bookmaker->name); ?></a></object></div>
		</div>
		<?php if($bookmaker->bonus > 0): ?>
			<div class="bookmaker-bonus">Бонус <b><?php echo e($bookmaker->bonus); ?> рублей</b></div>
		<?php endif; ?>
	</div>
	<div class="card-footer">
		<object><a class="btn btn-light" href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug])); ?>">Обзор</a></object>
		<object><a class="btn btn-light" href="<?php echo e($bookmaker->site); ?>" target="_blank" rel="nofollow">Сайт</a></object>
	</div>
</a>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/bookmaker/normal.blade.php ENDPATH**/ ?>