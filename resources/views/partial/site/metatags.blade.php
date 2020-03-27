<meta name="uffiliates" content="ok">
@if (filled(Crumb::get('seo_description')))
	<meta name="description" content="{{ Crumb::get('seo_description') }}">
@endif
@if (filled(Crumb::get('seo_keywords')))
	<meta name="keywords" content="{{ Crumb::get('seo_keywords') }}">
@endif
@if (filled(Crumb::get('og_site_name')))
	<meta property="og:site_name" content="{{ Crumb::get('og_site_name') }}">
@else
	<meta property="og:site_name" content="{{ config('app.name') }}">
@endif
@if (filled(Crumb::get('og_type')))
	<meta property="og:type" content="{{ Crumb::get('og_type') }}">
@else
	<meta property="og:type" content="website">
@endif
@if (filled(Crumb::get('og_title')))
	<meta property="og:title" content="{{ Crumb::get('og_title') }}">
@else
	<meta property="og:title" content="{{ Crumb::name() }}">
@endif
@if (filled(Crumb::get('og_url')))
	<meta property="og:url" content="{{ Crumb::get('og_url') }}">
@else
	<meta property="og:url" content="{{ url()->current() }}">
@endif
@if (filled(Crumb::get('og_image')))
	<meta property="og:image" content="{{ Crumb::get('og_image') }}">
	@if (filled(Crumb::get('og_image_width')) and filled(Crumb::get('og_image_height')))
		<meta property="og:image:width" content="{{ Crumb::get('og_image_width') }}">
		<meta property="og:image:height" content="{{ Crumb::get('og_image_height') }}">
	@endif
@else
	<meta property="og:image" content="{{ asset('/preview/600/383/images/logo-big.png') }}">
	<meta property="og:image:width" content="600">
	<meta property="og:image:height" content="383">
@endif
@if (filled(Crumb::get('og_description')))
	<meta property="og:description" content="{{ strip_tags(Crumb::get('og_description')) }}">
@elseif (filled(Crumb::get('seo_description')))
	<meta property="og:description" content="{{ strip_tags(Crumb::get('seo_description')) }}">
@endif