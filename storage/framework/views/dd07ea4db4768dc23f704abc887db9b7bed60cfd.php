<?php
	$name = modelName($tab ?? $model);
?>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('index', $model)): ?>
	<li class="nav-item"><a class="nav-link" href="#<?php echo e(str_plural($name)); ?>" data-toggle="tab"><?php echo app('translator')->get("page.office.{$name}.index"); ?></a></li>
<?php endif; ?>
<?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/plate/nested-tab.blade.php ENDPATH**/ ?>