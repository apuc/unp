<li>
    <a href="<?php echo e(url('/logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-sign-out" aria-hidden="true"></i><span>Выход</span>
    </a>

    <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" style="display: none;">
        <?php echo e(csrf_field()); ?>

    </form>
</li><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/office/shell/header-logout.blade.php ENDPATH**/ ?>