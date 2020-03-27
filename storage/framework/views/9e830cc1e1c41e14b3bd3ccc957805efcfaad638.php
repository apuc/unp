<div class="card news-card">
	<div class="card-header">
		<span class="name"><a href="<?php echo e(route('site.post.index')); ?>">Статьи</a> / <a href="<?php echo e(route('site.post.index', ['sport' => $post->sport->slug ])); ?>"><?php echo e($post->sport->name); ?></a></span>
		
	</div>
	<div class="card-body">
		<a href="<?php echo e(route('account.post.edit', ['post_id' => $post->id])); ?>" class="card-image-top">
			<img src="<?php echo e(asset('preview/512/223/storage/posts/' . $post->picture)); ?>" alt="<?php echo e($post->name); ?>">
		</a>
		<h3><a href="<?php echo e(route('account.post.edit', ['post_id' => $post->id])); ?>"><?php echo e($post->name); ?></a></h3>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<?php if($post->poststatus->slug == 'confirmed'): ?>
				<a href="<?php echo e(route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)])); ?>#post-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo e($post->postcomments_count); ?></a>
			<?php endif; ?>
		</div>
		<div class="card-user">
			<div class="user-name">
				<span class="text-uppercase"><?php echo e($post->poststatus->name); ?></span>
				<time><?php echo e($post->posted_at->format('d.m.Y H:i')); ?></time>
			</div>
			<div class="user-img">
				<img src="<?php echo e(asset('preview/33/33/storage/users/' . $post->user->avatar)); ?>" alt="<?php echo e($post->user->nickname); ?>">
			</div>
		</div>
	</div>
</div>

<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/post/own.blade.php ENDPATH**/ ?>