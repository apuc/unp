<div class="row">
	<div class="col-lg-4 col-xl-3">
		<div class="box">
			<div class="box-header">
				{{ $toolbar }}
			</div>

			<div class="box-body">
				{{ $form }}
			</div>
		</div>
	</div>

	<div class="col-lg-8 col-xl-9">
		@unless(empty($tabs))
			<div class="box nav-tabs-custom nav-flag-active">
				<ul class="nav nav-tabs">
					{{ $tabs }}
				</ul>
				<script>
					$('.nav-flag-active li').eq(0).find('> a').addClass('active');
				</script>

				<div class="tab-content tab-flag-active">
					{{ $panels }}

					<script>
						$('.tab-flag-active .tab-pane').eq(0).addClass('active');
					</script>
				</div>
			</div>
		@endunless
	</div>
</div>

@unless(empty($tabs))
	@include('partial.office.shell.modal-editor', [
		'action' => 'create'
	])
@endunless

@include('partial.office.shell.modal-editor', [
	'action' => 'edit'
])