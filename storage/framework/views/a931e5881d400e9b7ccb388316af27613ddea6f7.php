<div class="card deals-card">
	<div class="card-header">
		<span class="name"><a href="<?php echo e(route('site.deal.index')); ?>">Акции</a> / <a href="<?php echo e(route('site.bookmaker.show', ['bookmaker' => $deal->bookmaker->slug])); ?>"><?php echo e($deal->bookmaker->name); ?></a></span>
		
	</div>
	<div class="card-body">
		<a class="deals-card__link" href="<?php echo e($deal->url); ?>" target="_blank" rel="nofollow">
			<div class="deals-card__image">
				<img src="<?php echo e(asset('preview/222/180/storage/deals/' . $deal->cover)); ?>" alt="<?php echo e($deal->name); ?>">
			</div>
			<div class="deals-card__title"><?php echo e($deal->name); ?></div>
		</a>
	</div>
	<div class="card-footer">
		<a class="btn btn-light" href="<?php echo e(route('site.deal.show', ['deal' => $deal->id])); ?>">Подробнее</a>
		<a class="btn btn-light" href="<?php echo e($deal->url); ?>" target="_blank" rel="nofollow">Участвовать</a>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/deal/normal.blade.php ENDPATH**/ ?>