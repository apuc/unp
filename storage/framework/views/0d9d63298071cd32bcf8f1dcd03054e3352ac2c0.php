    <?php echo $__env->make('control.office.table.show',   ['route' => route('office.' . $routeController . '.show',     $id)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('control.office.table.edit',   ['route' => route('office.' . $routeController . '.edit',     $id)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('control.office.table.delete', ['route' => route('office.' . $routeController . '.destroy',  $id)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/control/office/toolbar/row.blade.php ENDPATH**/ ?>