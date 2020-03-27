<div class="card comment-card">
	<div class="card-header">
		<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
	</div>
	<div class="card-body">
		<?php echo e($forecastcomment->message); ?>

	</div>
   	<div class="card-footer">
   		<div class="card-icons">
   			
   		</div>
   		<div class="card-user">
   			<div class="user-name">
   				<a href="<?php echo e(route('site.user.show', ['login' => $forecastcomment->user->login])); ?>"><?php echo e($forecastcomment->user->name); ?></a>
   				<time><?php echo e($forecastcomment->posted_at->format('d.m.Y H:i')); ?></time>
   			</div>
			<div class="user-img">
				<a href="<?php echo e(route('site.user.show', ['login' => $forecastcomment->user->login])); ?>">
					<img src="<?php echo e(asset('preview/33/33/storage/users/' . $forecastcomment->user->avatar)); ?>" alt="<?php echo e($forecastcomment->user->nickname); ?>">
				</a>
			</div>
   		</div>
   	</div>
</div>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/forecastcomment/normal.blade.php ENDPATH**/ ?>