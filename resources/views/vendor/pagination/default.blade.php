@if ($paginator->hasPages())
	<nav class="pagination-box d-flex flex-column flex-md-row justify-content-between">
		<ul class="pagination pagination-sm">
			{{-- Previous Page Link --}}
			@if ($paginator->onFirstPage())
				<li class="page-item disabled">
					<a class="page-link" href="#" aria-label="">
						<span class="page-arrow" aria-hidden="true">&laquo;</span>
					</a>
				</li>
			@else
				<li class="page-item">
					<a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="">
						<span class="page-arrow" aria-hidden="true">&laquo;</span>
					</a>
				</li>
			@endif

			{{-- Pagination Elements --}}
			@foreach ($elements as $element)
				{{-- "Three Dots" Separator --}}
				@if (is_string($element))
					<li class="page-item disabled">
						<a class="page-link" href="#" aria-label="">
							<span>{{ $element }}</span>
						</a>
					</li>
				@endif

				{{-- Array Of Links --}}
				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<li class="page-item active"><a class="page-link" href="#">{{ $page }}</a></li>
						@else
							<li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
						@endif
					@endforeach
				@endif
			@endforeach

			{{-- Next Page Link --}}
			@if ($paginator->hasMorePages())
				<li class="page-item">
					<a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="">
						<span class="page-arrow" aria-hidden="true">&raquo;</span>
					</a>
				</li>
			@else
				<li class="page-item disabled">
					<a class="page-link" href="#" aria-label="">
						<span class="page-arrow" aria-hidden="true">&raquo;</span>
					</a>
				</li>
			@endif
		</ul>

		<div class="pagination-txt">@lang('pagination.counter', ['first' => $paginator->firstItem(), 'last' => $paginator->lastItem(), 'total' => $paginator->total()])</div>
	</nav>
@endif