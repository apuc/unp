<a class="card user-card" href="<?php echo e(route('site.user.show', ['login' => $user->login])); ?>">
	<div class="card-body">
		<div class="card-user">
			<div class="user-img">
				<?php if(isset($user->avatar)): ?>
					<object><a href="<?php echo e(route('site.user.show', ['login' => $user->login])); ?>">
						<img src="<?php echo e(asset('preview/33/33/storage/users/' . $user->avatar)); ?>" alt="<?php echo e($user->nickname); ?>">
					</a></object>
				<?php endif; ?>
			</div>
			<object><a href="<?php echo e(route('site.user.show', ['login' => $user->login])); ?>" class="user-name"><?php echo e($user->nickname); ?></a></object>
		</div>
		<div class="user-profit">
			Прибыль <b><span style="color:<?php echo e($user->stat_profit > 0 ? 'green' : 'red'); ?>;"><?php echo e(sprintf("%0.02f", $user->stat_profit)); ?>%</span></b>
		</div>
	</div>
</a>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/user/home.blade.php ENDPATH**/ ?>