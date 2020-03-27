<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="format-detection" content="telephone=no">
	<title><?php echo $__env->yieldContent('title'); ?></title>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="<?php echo e(mix('/assets/site/css/app.css')); ?>">
</head>
<body class="error">
	<div class="error-container">
		<a href="<?php echo e(route('site.home.index')); ?>" class="error-logo"><img src="preview/400/255/images/logo-big.png" alt="sportliga.com"></a>
		<div class="error-number">
			<?php echo $__env->yieldContent('code'); ?>
		</div>	
    	<h2><?php echo $__env->yieldContent('message'); ?></h2>
    	<p><?php echo $__env->yieldContent('description'); ?></p>
    	<hr>
    	<p>Вы можете перейти на <a href="<?php echo e(route('site.home.index')); ?>">Главную страницу</a><br>или воспользоваться <a href="<?php echo e(route('site.sitemap.index')); ?>">Картой&nbsp;сайта</a>.</p>
	</div>
</body>
</html>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/errors/minimal.blade.php ENDPATH**/ ?>