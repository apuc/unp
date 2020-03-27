<script>
	$(document).ready(function () {
		// событие перед выгрузкой списка юзеров
		$('#user').bind('ssSearchLoad', function () {
			search_user_id
				.addField('type', 'briefs')
			;
		});
	});
</script>