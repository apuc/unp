@php
	$name = modelName($tab ?? $model);
@endphp
@can('index', $model)
	<li class="nav-item"><a class="nav-link" href="#{{ str_plural($name) }}" data-toggle="tab">@lang("page.office.{$name}.index")</a></li>
@endcan
