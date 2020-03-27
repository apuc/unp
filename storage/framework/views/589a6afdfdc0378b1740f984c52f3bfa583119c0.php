<?php if(filled($document = $section->sitetexts->firstWhere('slug', $text))): ?>
	<?php echo $document->content; ?>

<?php endif; ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/site/text.blade.php ENDPATH**/ ?>