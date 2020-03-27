@extends('layout.site.grid.double')

@section('content')
    <div class="card-wrap">
    	<h2 class="title">Вопросы</h2>

    	<div class="questions-accordion accordion" id="questions">
			@if ($helpsection->helpquestions->count())
				@foreach ($helpsection->helpquestions as $helpquestion)
					<div class="card">
						<div class="question" id="heading-{{ $helpquestion->id }}">
							<p class="collapsed" data-toggle="collapse" data-target="#question-{{ $helpquestion->id }}" aria-expanded="false" aria-controls="#question-{{ $helpquestion->id }}">
								{{ $helpquestion->name }}
							</p>
						</div>
						<div id="question-{{ $helpquestion->id }}" class="collapse" aria-labelledby="heading-{{ $helpquestion->id }}" data-parent="#questions">
							<div class="card-body">
								{!! $helpquestion->answer !!}
							</div>
						</div>
					</div>
				@endforeach
			@endif	
		</div>

		{{--
		<div class="btn-more-box">
    		<a href="#" class="btn btn-more">Ещё вопросы</a>
    	</div>
    	--}}
	</div>
@endsection

@section('top')
	@if (filled($helpsection->text_header))
	   	<section class="text-top">
   			{!! $helpsection->text_header !!}
	   	</section>
   	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.info', ['current' => 'site.help.section'])
@endsection

@section('bottom')
	@if (filled($helpsection->text_footer))
	   	<section class="text-bottom">
   			{!! $helpsection->text_footer !!}
	   	</section>
   	@endif
@endsection

