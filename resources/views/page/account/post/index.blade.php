@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap">
		<div id="view-cards-box">
			<div class="sorting d-flex justify-content-end">
				<div class="sort-box mr-auto">
					<span class="sort-box__title">Сортировка</span>
					<div class="sort-box__select">
						<select class="form-control form-control-sm">
							<option selected="selected" value="">Новые</option>
							<option value="">Комментируемые</option>
							<option value="">Цитируемые</option>
						</select>
					</div>
				</div>

				<div class="product-view">
					<span class="product-view__title">Вид</span>
					<span class="product-view__item view-as-grid selected" title="Плитка"><i></i></span>
					<span class="product-view__item view-as-list" title="Список"><i></i></span>
				</div>
			</div>

			@if ($posts->count())
				<div class="cards-box cards_tile">
					<div class="row">
						@foreach ($posts as $post)
							<div class="col-12 col-md-6 col-lg-4">
								@include('card.site.post.own', [
									'post' => $post,
								])
							</div>
						@endforeach
					</div>
				</div>
			@endif

			<div class="btn-more-box">
				<a href="#" class="btn btn-more">Ещё статьи</a>
			</div>
		</div>
	</div>
@endsection

@section('top')
	<section class="text-top">
		<div class="row">
			<div class="col-12 col-lg-9">
				&nbsp;
			</div>
			<div class="col-12 col-lg-3 text-center align-self-end">
				<a href="{{ route('account.post.create') }}" class="btn btn-primary btn-lg"><i class="fa fa-plus" aria-hidden="true"></i> опубликовать статью</a>
			</div>
		 </div>
	</section>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection