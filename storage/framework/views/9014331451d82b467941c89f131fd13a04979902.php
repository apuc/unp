<a class="card user-card" href="<?php echo e(route('site.user.show', ['login' => $user->login])); ?>">
	<div class="card-header">
		<span class="name"><object><a href="<?php echo e(route('site.user.index')); ?>">Капперы</a></object></span>
		
	</div>
	<div class="card-body">
		<div class="card-user">
			<div class="user-img">
				<?php if(isset($user->avatar)): ?>
					<img src="<?php echo e(asset('preview/33/33/storage/users/' . $user->avatar)); ?>" alt="<?php echo e($user->nickname); ?>">
				<?php endif; ?>
			</div>
			<object><a class="user-name" href="<?php echo e(route('site.user.show', ['login' => $user->login])); ?>"><?php echo e($user->login); ?></a></object>
		</div>
		<div class="user-card__info">
			<div class="info-row">
				<div class="info-col">Прибыль</div>
				<div class="info-col"><span style="color:<?php echo e($user->stat_profit > 0 ? 'green' : 'red'); ?>"><?php echo e(sprintf("%0.02f", $user->stat_profit)); ?>%</span></div>
			</div>
			<div class="info-row">
				<div class="info-col">ROI</div>
				<div class="info-col"><?php echo e(sprintf("%0.02f", $user->stat_roi)); ?>% </div>
			</div>
			<div class="info-row">
				<div class="info-col">Прогнозов</div>
				<div class="info-col"><?php echo e($user->stat_forecasts); ?></div>
			</div>
			<div class="info-row">
				<div class="info-col"><span style="color:green">В</span> / <span style="color:red">П</span> / <span style="color:#b07d2b">О</span></div>
				<div class="info-col"><span style="color:green"><?php echo e($user->stat_wins); ?></span> / <span style="color:red"><?php echo e($user->stat_losses); ?></span>  / <span style="color:#b07d2b"><?php echo e($user->stat_draws); ?></span></div>
			</div>
			<div class="info-row">
				<div class="info-col">Средний коэф.</div>
				<div class="info-col"><?php echo e(sprintf("%0.02f", $user->stat_offer)); ?></div>
			</div>
			
			<div class="info-row">
				<div class="info-col">% выигрышей</div>
				<div class="info-col"><?php echo e($user->stat_luck); ?>%</div>
			</div>
			<div class="info-row">
				<div class="info-col">Банк</div>
				<div class="info-col"><?php echo e($user->balance); ?></div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<object><a class="btn btn-light" href="<?php echo e(route('site.user.show', ['login' => $user->login])); ?>">Страница</a></object>
		<object><a class="btn btn-light" href="<?php echo e(route('site.forecast.index', ['capper' => $user->login])); ?>">Прогнозы</a></object>
	</div>
</a>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/user/normal.blade.php ENDPATH**/ ?>