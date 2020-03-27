<?php $__env->startSection('content'); ?>
	<div id="description" class="card card-detail">
		<div class="card-header">
			<span class="name"><a href="<?php echo e(route('site.post.index')); ?>">Статьи</a> / <a href="<?php echo e(route('site.post.index', ['sport' => $post->sport->slug ])); ?>"><?php echo e($post->sport->name); ?></a></span>
			
		</div>
		<div class="card-body">
			<figure class="text-center">
				<img class="img-fluid" src="<?php echo e(asset('preview/782/435/storage/posts/' . $post->picture)); ?>" alt="">
				<?php if(isset($post->picture_author)): ?>
					<figcaption class="figure-caption text-center">ФОТО: <?php echo e($post->picture_author); ?></figcaption>
				<?php endif; ?>
			</figure>

			<?php echo $post->content; ?>


			<div class="share-with">
				<p>Поделиться статьей</p>
				<?php echo $__env->make('partial.site.share', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
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

	<?php if(!Auth::guest()): ?>
		<div id="post-comment" class="card-wrap">
			<h2 class="title">ВАШ КОММЕНТАРИЙ</h2>
			<form action="<?php echo e(route('site.post.comment', ['post' => URI::asSlug($post->id, $post->name)])); ?>" method="post">
				<?php echo e(csrf_field()); ?>

				<textarea name="message" class="form-control" placeholder="введите текст комментария"></textarea>
				<div class="btn-more-box">
					<button type="submit" class="btn btn-primary pl-4 pr-4">Отправить</button>
				</div>
			</form>
		</div>
	<?php endif; ?>

	<?php if($post->postcomments->count()): ?>
		<div id="post-comments" class="card-wrap">
			<h2 class="title">КОММЕНТАРИИ <span><?php echo e($post->postcomments_count); ?></span></h2>

			<?php $__currentLoopData = $post->postcomments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $postcomment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make('card.site.postcomment.normal', [
					'postcomment' => $postcomment,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			
		</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/post/show.blade.php ENDPATH**/ ?>