<meta name="uffiliates" content="ok">
<?php if(filled(Crumb::get('seo_description'))): ?>
	<meta name="description" content="<?php echo e(Crumb::get('seo_description')); ?>">
<?php endif; ?>
<?php if(filled(Crumb::get('seo_keywords'))): ?>
	<meta name="keywords" content="<?php echo e(Crumb::get('seo_keywords')); ?>">
<?php endif; ?>
<?php if(filled(Crumb::get('og_site_name'))): ?>
	<meta property="og:site_name" content="<?php echo e(Crumb::get('og_site_name')); ?>">
<?php else: ?>
	<meta property="og:site_name" content="<?php echo e(config('app.name')); ?>">
<?php endif; ?>
<?php if(filled(Crumb::get('og_type'))): ?>
	<meta property="og:type" content="<?php echo e(Crumb::get('og_type')); ?>">
<?php else: ?>
	<meta property="og:type" content="website">
<?php endif; ?>
<?php if(filled(Crumb::get('og_title'))): ?>
	<meta property="og:title" content="<?php echo e(Crumb::get('og_title')); ?>">
<?php else: ?>
	<meta property="og:title" content="<?php echo e(Crumb::name()); ?>">
<?php endif; ?>
<?php if(filled(Crumb::get('og_url'))): ?>
	<meta property="og:url" content="<?php echo e(Crumb::get('og_url')); ?>">
<?php else: ?>
	<meta property="og:url" content="<?php echo e(url()->current()); ?>">
<?php endif; ?>
<?php if(filled(Crumb::get('og_image'))): ?>
	<meta property="og:image" content="<?php echo e(Crumb::get('og_image')); ?>">
	<?php if(filled(Crumb::get('og_image_width')) and filled(Crumb::get('og_image_height'))): ?>
		<meta property="og:image:width" content="<?php echo e(Crumb::get('og_image_width')); ?>">
		<meta property="og:image:height" content="<?php echo e(Crumb::get('og_image_height')); ?>">
	<?php endif; ?>
<?php else: ?>
	<meta property="og:image" content="<?php echo e(asset('/preview/600/383/images/logo-big.png')); ?>">
	<meta property="og:image:width" content="600">
	<meta property="og:image:height" content="383">
<?php endif; ?>
<?php if(filled(Crumb::get('og_description'))): ?>
	<meta property="og:description" content="<?php echo e(strip_tags(Crumb::get('og_description'))); ?>">
<?php elseif(filled(Crumb::get('seo_description'))): ?>
	<meta property="og:description" content="<?php echo e(strip_tags(Crumb::get('seo_description'))); ?>">
<?php endif; ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/site/metatags.blade.php ENDPATH**/ ?>