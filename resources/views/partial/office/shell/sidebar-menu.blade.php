@php
	$first = $first ?? false;
@endphp

@if ($first === true)
	<!-- первое меню -->
	<ul class="nav nav-tabs nav-main align-self-start">
		@foreach ($sections as $section => $groups)
			<li class="nav-item"><a class="nav-link{{ $section == $activeSection ? ' active' : '' }}" href="#menu-{{ $section }}" data-toggle="tab">@lang('sidebar.office.group.' . $section)</a></li>
		@endforeach
	</ul>
@endif

@if ($first === false)
	<!-- второе меню -->
	<div class="tab-content clearfix menu-documents">
		@foreach ($sections as $section => $groups)
			<div class="tab-pane{{ $section == $activeSection ? ' active' : '' }}" id="menu-{{ $section }}">
				<ul class="nav nav-tabs nav-menu">
					@foreach ($groups as $group => $items)
						<li class="nav-item">
							<a
								class="nav-link{{ (($section != $activeSection && collect($groups)->keys()->first() == $group) || $group == $activeGroup) ? ' active' : '' }}"
								href="#submenu-{{ md5($group) }}"
								id="submenu-{{ md5($group) }}-tab"
								aria-controls="submenu-{{ md5($group) }}"
								data-toggle="tab">
									@lang('sidebar.office.subgroup.' . $group)
							</a>
						</li>
					@endforeach
				</ul>

				<!-- третье меню -->
				<div class="tab-content clearfix nav-submenu">
					@foreach ($groups as $group => $items)
						<div
							class="tab-pane{{ (($section != $activeSection && collect($groups)->keys()->first() == $group ) || $group == $activeGroup) ? ' active' : '' }}"
							id="submenu-{{ md5($group) }}"
							aria-labelledby="submenu-{{ md5($group) }}-tab"
							aria-expanded="true"
						>
							<nav class="nav treeview-menu">
								@foreach($items as $item => $permission)
									<a
										class="nav-link{{ $item == $activeItem ? ' active' : '' }}"
										href="{{ route($item) }}"
									>@lang('page.' . $item)</a>
								@endforeach
							</nav>
						</div>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>

	@php
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
	@endphp

	<div class="container-fluid mobile-menu">
		<div class="nav-toggle" id="navMenu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span><i class="fa fa-times" aria-hidden="true"></i></span></div>
		<!-- для мобилы -->
		<div class="win-nav dropdown-menu clearfix" aria-labelledby="navMenu">
			<ul>
				@foreach ($sections as $section => $groups)
					<li>
						<span>@lang('sidebar.office.group.' . $section)</span>
						<ul>
							@foreach ($groups as $group => $items)
								<li>
									<span>@lang('sidebar.office.subgroup.' . $group)</span>
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
@endif