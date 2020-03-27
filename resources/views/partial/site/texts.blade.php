@foreach ($section->sitetexts as $text)
    <div class="card-wrap">
    	<h2 class="title">{!! $text->title !!}</h2>
    	{!! $text->content !!}
	</div>
@endforeach