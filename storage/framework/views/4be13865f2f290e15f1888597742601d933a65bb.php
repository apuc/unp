<div class="card article-card">
	<div class="card-header">
		<span class="name"><a href="<?php echo e(route('site.post.index')); ?>">Статьи</a> / <a href="<?php echo e(route('site.post.index', ['sport' => $post->sport->slug ])); ?>"><?php echo e($post->sport->name); ?></a></span>
		
	</div>
	<div class="card-body">
		<a href="<?php echo e(route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)])); ?>" class="card-image-top">
			<img src="<?php echo e(asset('preview/512/223/storage/posts/' . $post->picture)); ?>" alt="<?php echo e($post->name); ?>">
		</a>
		<h3><a href="<?php echo e(route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)])); ?>"><?php echo e($post->name); ?></a></h3>
		<p><?php echo e($post->announce); ?></p>
	</div>
	<div class="card-footer">
		<div class="card-icons">
			<a href="<?php echo e(route('site.post.show', ['post' => URI::asSlug($post->id, $post->name)])); ?>#post-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo e($post->postcomments_count); ?></a>
		</div>
		<div class="card-user">
			<div class="user-name">
				<a href="<?php echo e(route('site.user.show', ['login' => $post->user->login])); ?>"><?php echo e($post->user->nickname); ?></a>
				<time><?php echo e($post->posted_at->format('d.m.Y H:i')); ?></time>
			</div>
			<div class="user-img">
				<a href="<?php echo e(route('site.user.show', ['login' => $post->user->login])); ?>">
					<img src="<?php echo e(asset('preview/33/33/storage/users/' . $post->user->avatar)); ?>" alt="<?php echo e($post->user->nickname); ?>">
				</a>
			</div>
		</div>
	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/post/normal.blade.php ENDPATH**/ ?>