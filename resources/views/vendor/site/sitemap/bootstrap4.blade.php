<ul class="list-unstyled{{ false === $sitemap->root ? ' pl-3' : '' }}{{ (isset($level) && $level > 0) ? ' hidden' : '' }}">
	@foreach ($sitemap->nodes as $node)
		@if (true === $node->pagination)
			<li class="list-inline-item"><a href="{{ $node->loc }}">{{ $node->name }}</a></li>
		@else
			<li>
				@if (isset($level) && $level >= 0)
					<table>
						<tbody>
							<tr>
							<td width="15">
								@if (filled($node->nodes) && $node->nodes->count())
									<a onclick="sitemap.toggle($(this));" href="javascript: void(0);"><i class="fa fa-plus" aria-hidden="true"></i></a>
								@else
									<br>
								@endif
							</td>
							<td>
								<a href="{{ $node->loc }}">{{ $node->name }}</a>
							</td>
						</tr>
						</tbody>
					</table>
				@else
					<a href="{{ $node->loc }}">{{ $node->name }}</a>
				@endif

				@if (null !== $node->nodes && $node->nodes->count())
					@include('vendor.site.sitemap.bootstrap4', [
						'sitemap'	=> $node,
						'level'		=> isset($level) ? $level + 1 : 0
					])
				@endif
			</li>
		@endif
	@endforeach
</ul>