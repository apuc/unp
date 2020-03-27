@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap account-forecasts-detail">
		<h2 class="title">Новость</h2>
		<form id="brief-form" action="{{ route('account.brief.update', ['brief_id' => $brief->id]) }}" method="post" enctype="multipart/form-data" onsubmit="return false;">
			<input type="hidden" name="briefstatus_id" value="">
			{{ csrf_field() }}
			<div class="form-group row">
				<label for="name" class="col-md-3 col-form-label">Заголовок <span class="red">*</span></label>
				<div class="col-md-9">
					<input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="name" value="{{ old('name') ?? $brief->name }}">
					@if ($errors->has('name'))
						<div class="invalid-feedback">{{ $errors->first('name') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-3 col-form-label">Изображение <span class="red">*</span></label>
				<div class="ss-filebrowse col-md-9 d-flex">
					<img src="{{ asset('preview/80/80/storage/briefs/' . $brief->picture) }}" alt="{{ $brief->name }}">
					<div class="avatar-act">
						<label for="picture" class="btn btn-light">Загрузить изображение</label>
						<input class="form-control{{ $errors->has('picture') ? ' is-invalid' : '' }}" type="file" hidden id="picture" name="picture">
						@if ($errors->has('picture'))
							<div class="invalid-feedback">{{ $errors->first('picture') }}</div>
						@endif
					</div>
				</div>
			</div>

			<div class="form-group row">
				<label for="author-img" class="col-md-3 col-form-label">Автор изображения</label>
				<div class="col-md-9">
					<input type="text" class="form-control{{ $errors->has('picture_author') ? ' is-invalid' : '' }}" name="picture_author" id="author-img" value="{{ old('picture_author') ?? $brief->picture_author }}">
					@if ($errors->has('picture_author'))
						<div class="invalid-feedback">{{ $errors->first('picture_author') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<label for="announce" class="col-md-3 col-form-label">Краткий анонс <span class="red">*</span></label>
				<div class="col-md-9">
					<textarea class="form-control{{ $errors->has('announce') ? ' is-invalid' : '' }}" name="announce" id="announce" rows="5">{{ old('announce') ?? $brief->announce }}</textarea>
					@if ($errors->has('announce'))
						<div class="invalid-feedback">{{ $errors->first('announce') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group">
				<label for="text">Текст <span class="red">*</span></label>
				<div>
					{{--<img src="storage/profile/text-icons.png" class="img-fluid" alt="">--}}
					<textarea name="content" class="form-control{{ $errors->has('content') ? ' is-invalid' : '' }}" id="text" rows="10">{{ old('content') ?? $brief->content }}</textarea>
					@if ($errors->has('content'))
						<div class="invalid-feedback">{{ $errors->first('content') }}</div>
					@endif
				</div>
			</div>

			<div class="form-group row">
				<label for="sport" class="col-md-3 col-form-label">Вид спорта <span class="red">*</span></label>
				<div class="col-md-9">
					<select name="sport_id" class="form-control{{ $errors->has('sport_id') ? ' is-invalid' : '' }}" id="sport">
						<option valeu="">-- Выберите вид спорта</option>
						@foreach ($sports as $sport)
							<option {!! ($sport->id == old('sport_id') || $sport->id == $brief->sport_id) ? 'selected="selected"' : '' !!} value="{{ $sport->id }}">{{ $sport->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('sport_id'))
						<div class="invalid-feedback">{{ $errors->first('sport_id') }}</div>
					@endif
				</div>
			</div>

			{{--
			<div class="form-group row">
				<label for="tags" class="col-md-3 col-form-label">Теги <span class="red">*</span></label>
				<div class="col-md-9">
					<select name="tag_id" class="form-control{{ $errors->has('tag_id') ? ' is-invalid' : '' }}" id="tags">
						<option valeu="">-- Выберите тег</option>
						@foreach ($tags as $tag)
							<option {!! ($tag->id == old('tag_id') || $tag->id == $brief->brieftags->first()->tag_id ) ? 'selected="selected"' : '' !!} value="{{ $tag->id }}">{{ $tag->name }}</option>
						@endforeach
					</select>
					@if ($errors->has('tag_id'))
						<div class="invalid-feedback">{{ $errors->first('tag_id') }}</div>
					@endif
				</div>
			</div>
			--}}

			<div class="btn-account-row">
				@if ($brief->briefstatus->slug == 'moderation' || $brief->briefstatus->slug == 'draft')
					<a href="javascript: void(0);" onclick="submitBrief('{{ $briefstatusmoderation->id }}');" class="btn btn-primary">На проверку</a>
					<a href="javascript: void(0);" onclick="submitBrief('{{ $briefstatusdraft->id }}');" class="btn btn-more">Сохранить черновик</a>
				@endif
				<span>Сохранено в {{ $brief->updated_at->format('H:i') }}</span>
				{{--<a href="#" class="btn btn-link">Предпросмотр</a>--}}
				@if ($brief->briefstatus->slug == 'draft')
					<a href="javascript: void(0);" onclick="destroyBrief('{{ route('account.brief.destroy', ['brief_id' => $brief->id]) }}');" class="btn btn-light mr-0 ml-md-auto"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
				@endif
			</div>
			<script>
				function submitBrief(briefstatus_id)
				{
					$('#brief-form').find("input[name='briefstatus_id']").val(briefstatus_id);
					$('#brief-form').attr('onsubmit', '');
					$('#brief-form').submit();
				}

				function destroyBrief(route, step)
				{

					if (step === undefined) {
						if (confirm("Вы уверены что хотите удалить эту новость?"))
							destroyBrief(route, 1);
					}

					if (step === 1)
						$.brief(route, {
							'_token': '{{ csrf_token() }}'
						}, function () {
							location.href = '{{ route('account.brief.index') }}';
						});
				}
			</script>
		</form>
	</div>

	<section class="text-bottom">
		<p>Если нажать "НА ПРОВЕРКУ", новость сохранится и отправится для проверки модератором. В случае, если она удовлетворяет <a href="{{ route('site.legal.show', ['document' => 'rules']) }}">правилам сайта</a>, она будет опубликована.</p>
		<p>Если нажать "СОХРАНИТЬ ЧЕРНОВИК", новость сохранится и будет видна только Вам.</p>
	</section>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.account')
@endsection