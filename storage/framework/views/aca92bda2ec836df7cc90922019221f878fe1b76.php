<div class="card briefs-card">
	<div class="card-body">
		<time><?php echo e($brief->posted_at->format('H:i')); ?><span class="date"><?php echo e($brief->posted_at->format('d.m.Y')); ?></span></time>
		<?php if(null !== $brief->sport->icon): ?>
			<div class="sport-icon"><img src="<?php echo e(asset('storage/sports/' . $brief->sport->icon)); ?>" alt="<?php echo e($brief->sport->name); ?>"></div>
		<?php endif; ?>
		<p>
			<a href="<?php echo e(route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)])); ?>"><?php echo e($brief->name); ?></a>
			<?php if(null !== $brief->picture): ?>
				<span class="badge badge-secondary">фото</span>
			<?php endif; ?>

			<?php if($brief->briefcomments_count > 0): ?>
				<a href="<?php echo e(route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)])); ?>#brief-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i><?php echo e($brief->briefcomments_count); ?></a>
			<?php endif; ?>
		</p>
	</div>
</div><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/brief/normal.blade.php ENDPATH**/ ?>