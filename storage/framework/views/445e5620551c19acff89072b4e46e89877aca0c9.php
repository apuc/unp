<?php $__currentLoopData = $section->sitetexts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="card-wrap">
    	<h2 class="title"><?php echo $text->title; ?></h2>
    	<?php echo $text->content; ?>

	</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/texts.blade.php ENDPATH**/ ?>