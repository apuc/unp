<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?php echo e($title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="<?php echo e(mix('/assets/office/css/app.css')); ?>">
    <script src="<?php echo e(mix('/assets/office/js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('/assets/office/js/ckeditor/ckeditor.js')); ?>"></script>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="container-fluid d-flex justify-content-start align-items-center">
            <?php echo $__env->make('partial.office.shell.header-logo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partial.office.shell.sidebar-menu', ['first' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('partial.office.shell.sidebar-profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('partial.office.shell.sidebar-menu', ['first' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </header>
    <div class="content-wrapper">
        <?php echo Breadcrumbs::view('vendor/office/breadcrumbs/bootstrap4', $routeName, $parameters ?? []); ?>


        <?php echo $__env->make('partial.office.shell.alerts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <section class="content container-fluid">
            <?php echo $__env->make('partial.office.shell.content-title', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
        </section>
    </div>

    <footer>
        <div class="container-fluid d-flex flex-column flex-sm-row justify-content-between">
            <?php echo $__env->make('partial.office.shell.footer-copyright', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </footer>

    <?php echo $__env->make('partial.office.shell.modal-editor', ['action' => 'tpl'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
</body>
</html><!-- <?php echo e(config('app.name')); ?> v<?php echo e(config('app.version')); ?> -->
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/layout/office/app.blade.php ENDPATH**/ ?>