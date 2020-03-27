<article class="card legal-document">
	<h3><a href="<?php echo e(route('site.legal.show', ['document' => $slug])); ?>"><?php echo e($name); ?></a></h3>
	<time datetime="<?php echo e($issued_at->format('Y-m-d')); ?>"><?php echo app('translator')->get('message.site.legal.edition', ['issued_at' => Moment::asDate($issued_at)]); ?></time>
</article>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/card/site/legal/normal.blade.php ENDPATH**/ ?>