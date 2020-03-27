<?php
	$first = $first ?? false;
?>

<?php if($first === true): ?>
	<!-- первое меню -->
	<ul class="nav nav-tabs nav-main align-self-start">
		<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li class="nav-item"><a class="nav-link<?php echo e($section == $activeSection ? ' active' : ''); ?>" href="#menu-<?php echo e($section); ?>" data-toggle="tab"><?php echo app('translator')->get('sidebar.office.group.' . $section); ?></a></li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</ul>
<?php endif; ?>

<?php if($first === false): ?>
	<!-- второе меню -->
	<div class="tab-content clearfix menu-documents">
		<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="tab-pane<?php echo e($section == $activeSection ? ' active' : ''); ?>" id="menu-<?php echo e($section); ?>">
				<ul class="nav nav-tabs nav-menu">
					<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<li class="nav-item">
							<a
								class="nav-link<?php echo e((($section != $activeSection && collect($groups)->keys()->first() == $group) || $group == $activeGroup) ? ' active' : ''); ?>"
								href="#submenu-<?php echo e(md5($group)); ?>"
								id="submenu-<?php echo e(md5($group)); ?>-tab"
								aria-controls="submenu-<?php echo e(md5($group)); ?>"
								data-toggle="tab">
									<?php echo app('translator')->get('sidebar.office.subgroup.' . $group); ?>
							</a>
						</li>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</ul>

				<!-- третье меню -->
				<div class="tab-content clearfix nav-submenu">
					<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<div
							class="tab-pane<?php echo e((($section != $activeSection && collect($groups)->keys()->first() == $group ) || $group == $activeGroup) ? ' active' : ''); ?>"
							id="submenu-<?php echo e(md5($group)); ?>"
							aria-labelledby="submenu-<?php echo e(md5($group)); ?>-tab"
							aria-expanded="true"
						>
							<nav class="nav treeview-menu">
								<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<a
										class="nav-link<?php echo e($item == $activeItem ? ' active' : ''); ?>"
										href="<?php echo e(route($item)); ?>"
									><?php echo app('translator')->get('page.' . $item); ?></a>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</nav>
						</div>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</div>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>

	<?php
	/*
	<div class="container-fluid dropdown mobile-menu">
		<div class="nav-toggle" id="navMenu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fa fa-times" aria-hidden="true"></i></span></div>
		<!-- для мобилы -->
		<div class="win-nav clearfix" aria-labelledby="navMenu">
			<ul>
				@foreach ($sections as $section => $groups)
					<li>
						<span>@lang('sidebar.office.group.' . $section)</span>
						<ul>
							@foreach ($groups as $group => $items)
								<li>
									<span>@lang('page.' . $group)</span>
									<ul>
										@foreach($items as $item => $permission)
											<li{{ $item == $activeItem ? ' class=active' : '' }}>
												<a href="{{ route($item) }}">@lang('page.' . $item)</a>
											</li>
										@endforeach
									</ul>
								</li>
							@endforeach
						</ul>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
	*/
	?>

	<div class="container-fluid mobile-menu">
		<div class="nav-toggle" id="navMenu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fa fa-times" aria-hidden="true"></i></span></div>
		<!-- для мобилы -->
		<div class="win-nav dropdown-menu clearfix" aria-labelledby="navMenu">
			<ul>
				<?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section => $groups): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<li>
						<span><?php echo app('translator')->get('sidebar.office.group.' . $section); ?></span>
						<ul>
							<?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<li>
									<span><?php echo app('translator')->get('sidebar.office.subgroup.' . $group); ?></span>
									<ul>
										<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item => $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li<?php echo e($item == $activeItem ? ' class=active' : ''); ?>>
												<a href="<?php echo e(route($item)); ?>"><?php echo app('translator')->get('page.' . $item); ?></a>
											</li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>
								</li>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</ul>
					</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</ul>
		</div>
	</div>
<?php endif; ?><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/partial/office/shell/sidebar-menu.blade.php ENDPATH**/ ?>