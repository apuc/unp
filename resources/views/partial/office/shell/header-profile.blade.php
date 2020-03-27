<li>
	<a href="#" title="{{ Auth::user()->nickname }}">
		<i class="fa fa-user" aria-hidden="true"></i><em><b>{{ Auth::user()->nickname }}</b> &nbsp; {{ Auth::user()->role->name }}</em>
	</a>
</li>