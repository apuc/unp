@if (filled($document = $section->sitetexts->firstWhere('slug', $text)))
	{!! $document->content !!}
@endif