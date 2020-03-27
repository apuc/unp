<?php $__env->startSection('content'); ?>

	<h1><?php echo e($match->team1_name); ?> <?php echo e($match->score1); ?>:<?php echo e($match->score2); ?> <?php echo e($match->team2_name); ?></h1>
	<div><strong>Турнир:</strong> <?php echo e($match->tournament_name); ?></div>
	<div><strong>Начало:</strong> <?php echo e($match->startdate); ?></div>
	<div><strong>Статус:</strong> <?php echo e($match->status_type); ?></div>

	
	<?php if($outcomes->get('1x2')['ord']->count() || $outcomes->get('1x2')['1h']->count() || $outcomes->get('1x2')['2h']->count()): ?>
		<h2>1x2</h2>

		<?php if($outcomes->get('1x2')['ord']->count()): ?>
			<h3>Осн. время</h3>
			<?php $__currentLoopData = $outcomes->get('1x2')['ord']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / X: <?php echo e($bookmaker['offers']->get(0)->odds); ?> / 2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('1x2')['1h']->count()): ?>
			<h3>1-ый тайм</h3>
			<?php $__currentLoopData = $outcomes->get('1x2')['1h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / X: <?php echo e($bookmaker['offers']->get(0)->odds); ?> / 2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('1x2')['2h']->count()): ?>
			<h3>2-ой тайм</h3>
			<?php $__currentLoopData = $outcomes->get('1x2')['2h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / X: <?php echo e($bookmaker['offers']->get(0)->odds); ?> / 2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>

	
	<?php if($outcomes->get('12')['ord']->count() || $outcomes->get('12')['1h']->count() || $outcomes->get('12')['2h']->count()): ?>
		<h2>1 или 2</h2>
		<?php if($outcomes->get('12')['ord']->count()): ?>
			<h3>Осн. время</h3>
			<?php $__currentLoopData = $outcomes->get('12')['ord']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / 2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('12')['1h']->count()): ?>
			<h3>1-ый тайм</h3>
			<?php $__currentLoopData = $outcomes->get('12')['1h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / 2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('12')['2h']->count()): ?>
			<h3>2-ой тайм</h3>
			<?php $__currentLoopData = $outcomes->get('12')['2h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / 2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>

	
	<?php if($outcomes->get('dc')['ord']->count() || $outcomes->get('dc')['1h']->count() || $outcomes->get('dc')['2h']->count()): ?>
		<h2>Двойной шанс</h2>

		<?php if($outcomes->get('dc')['ord']->count()): ?>
			<h3>Осн. время</h3>
			<?php $__currentLoopData = $outcomes->get('dc')['ord']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1X: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / 12: <?php echo e($bookmaker['offers']->get(0)->odds); ?> / X2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('dc')['1h']->count()): ?>
			<h3>1-ый тайм</h3>
			<?php $__currentLoopData = $outcomes->get('dc')['1h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1X: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / 12: <?php echo e($bookmaker['offers']->get(0)->odds); ?> / X2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('dc')['2h']->count()): ?>
			<h3>2-ой тайм</h3>
			<?php $__currentLoopData = $outcomes->get('dc')['2h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / 1X: <?php echo e($bookmaker['offers']->get(1)->odds); ?> / 12: <?php echo e($bookmaker['offers']->get(0)->odds); ?> / X2: <?php echo e($bookmaker['offers']->get(2)->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>

	
	<?php if($outcomes->get('oe')['ord']->count() || $outcomes->get('oe')['1h']->count() || $outcomes->get('oe')['2h']->count()): ?>
		<h2>Чет/Нечет</h2>

		<?php if($outcomes->get('oe')['ord']->count()): ?>
			<h3>Осн. время</h3>
			<?php $__currentLoopData = $outcomes->get('oe')['ord']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / Нечет: <?php echo e($bookmaker['offers']->get('odd')->odds); ?> / Чет: <?php echo e($bookmaker['offers']->get('even')->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('oe')['1h']->count()): ?>
			<h3>1-ый тайм</h3>
			<?php $__currentLoopData = $outcomes->get('oe')['1h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / Нечет: <?php echo e($bookmaker['offers']->get('odd')->odds); ?> / Чет: <?php echo e($bookmaker['offers']->get('even')->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('oe')['2h']->count()): ?>
			<h3>2-ой тайм</h3>
			<?php $__currentLoopData = $outcomes->get('oe')['2h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / Нечет: <?php echo e($bookmaker['offers']->get('odd')->odds); ?> / Чет: <?php echo e($bookmaker['offers']->get('even')->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>

	
	<?php if($outcomes->get('bts')['ord']->count() || $outcomes->get('bts')['1h']->count() || $outcomes->get('bts')['2h']->count()): ?>
		<h2>Обе забьют?</h2>

		<?php if($outcomes->get('bts')['ord']->count()): ?>
			<h3>Осн. время</h3>
			<?php $__currentLoopData = $outcomes->get('bts')['ord']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / Да: <?php echo e($bookmaker['offers']->get('yes')->odds); ?> / Нет: <?php echo e($bookmaker['offers']->get('no')->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('bts')['1h']->count()): ?>
			<h3>1-ый тайм</h3>
			<?php $__currentLoopData = $outcomes->get('bts')['1h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / Да: <?php echo e($bookmaker['offers']->get('yes')->odds); ?> / Нет: <?php echo e($bookmaker['offers']->get('no')->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>

		<?php if($outcomes->get('bts')['2h']->count()): ?>
			<h3>2-ой тайм</h3>
			<?php $__currentLoopData = $outcomes->get('bts')['2h']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bookmaker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php echo e($bookmaker['name']); ?> / Да: <?php echo e($bookmaker['offers']->get('yes')->odds); ?> / Нет: <?php echo e($bookmaker['offers']->get('no')->odds); ?><br>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		<?php endif; ?>
	<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layout.site.debug', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/debug/match/show.blade.php ENDPATH**/ ?>