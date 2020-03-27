<div class="card news-card">
	<div class="card-header">
		<span class="name"><a href="<?php echo e(route('site.brief.index')); ?>">Новости</a> / <a href="<?php echo e(route('site.brief.index', ['sport' => $brief->sport->slug ])); ?>"><?php echo e($brief->sport->name); ?></a></span>
		
	</div>
	<div class="card-body">
		<a href="<?php echo e(route('account.brief.edit', ['brief_id' => $brief->id])); ?>" class="card-image-top">
			<img src="<?php echo e(asset('preview/512/223/storage/briefs/' . $brief->picture)); ?>" alt="<?php echo e($brief->name); ?>">
		</a>
		<h3><a href="<?php echo e(route('account.brief.edit', ['brief_id' => $brief->id])); ?>"><?php echo e($brief->name); ?></a></h3>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<?php if($brief->briefstatus->slug == 'confirmed'): ?>
				<a href="<?php echo e(route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)])); ?>#brief-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo e($brief->briefcomments_count); ?></a>
			<?php endif; ?>
		</div>
		<div class="card-user">
			<div class="user-name">
				<span class="text-uppercase"><?php echo e($brief->briefstatus->name); ?></span>
				<time><?php echo e($brief->posted_at->format('d.m.Y H:i')); ?></time>
			</div>
			<div class="user-img">
				<img src="<?php echo e(asset('preview/200/200/storage/users/' . $brief->user->avatar)); ?>" alt="<?php echo e($brief->user->nickname); ?>">
			</div>
		</div>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/brief/own.blade.php ENDPATH**/ ?>