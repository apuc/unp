<?php $__env->startSection('content'); ?>
	<div id="description" class="card card-detail">
		<div class="card-header">
			<span class="name"><a href="<?php echo e(route('site.brief.index')); ?>">Статьи</a> / <a href="<?php echo e(route('site.brief.index', ['sport' => $brief->sport->slug ])); ?>"><?php echo e($brief->sport->name); ?></a></span>
			
		</div>
		<div class="card-body">
			<?php if(null !== $brief->picture): ?>
				<figure class="text-center">
					<img class="img-fluid" src="<?php echo e(asset('preview/807/449/storage/briefs/' . $brief->picture)); ?>" alt="">
					<?php if(isset($brief->picture_author)): ?>
						<figcaption class="figure-caption text-center">ФОТО: <?php echo e($brief->picture_author); ?></figcaption>
					<?php endif; ?>
				</figure>
			<?php endif; ?>

			<?php echo $brief->content; ?>


			<div class="share-with">
				<p>Поделиться  новостью</p>
				<?php echo $__env->make('partial.site.share', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			</div>
		</div>
		<div class="card-footer">
			<div class="card-icons">
				<a href="<?php echo e(route('site.brief.show', ['brief' => URI::asSlug($brief->id, $brief->name)])); ?>#brief-comments" class="card-icon"><i class="fa fa-comment" aria-hidden="true"></i> <?php echo e($brief->briefcomments_count); ?></a>
			</div>
			<div class="card-user">
				<div class="user-name">
					<a href="<?php echo e(route('site.user.show', ['login' => $brief->user->login])); ?>"><?php echo e($brief->user->nickname); ?></a>
					<time><?php echo e($brief->posted_at->format('d.m.Y H:i')); ?></time>
				</div>
				<div class="user-img">
					<a href="<?php echo e(route('site.user.show', ['login' => $brief->user->login])); ?>">
						<img src="<?php echo e(asset('preview/33/33/storage/users/' . $brief->user->avatar)); ?>" alt="<?php echo e($brief->user->nickname); ?>">
					</a>
				</div>
			</div>
		</div>
	</div>

	<?php if(!Auth::guest()): ?>
		<div id="brief-comment" class="card-wrap">
			<h2 class="title">ВАШ КОММЕНТАРИЙ</h2>
			<form action="<?php echo e(route('site.brief.comment', ['brief' => URI::asSlug($brief->id, $brief->name)])); ?>" method="post">
				<?php echo e(csrf_field()); ?>

				<textarea name="message" class="form-control" placeholder="введите текст комментария"></textarea>
				<div class="btn-more-box">
					<button type="submit" class="btn btn-primary pl-4 pr-4">Отправить</button>
				</div>
			</form>
		</div>
	<?php endif; ?>

	<?php if($brief->briefcomments->count()): ?>
		<div id="brief-comments" class="card-wrap">
			<h2 class="title">КОММЕНТАРИИ <span><?php echo e($brief->briefcomments_count); ?></span></h2>

			<?php $__currentLoopData = $brief->briefcomments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $briefcomment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo $__env->make('card.site.briefcomment.normal', [
					'briefcomment' => $briefcomment,
				], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

			
		</div>
	<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('sidebar'); ?>
	<?php echo $__env->make('partial.site.sidebar.brief', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.site.grid.double', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/site/brief/show.blade.php ENDPATH**/ ?>