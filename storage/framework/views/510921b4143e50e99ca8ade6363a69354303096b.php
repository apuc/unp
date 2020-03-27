<script>
	$(document).ready(function () {
		// событие перед выгрузкой списка юзеров
		$('#user').bind('ssSearchLoad', function () {
			search_user_id
				.addField('type', 'posts')
			;
		});

		// авто заполнение юзера
		var autocompleteuser = false;
		$('#user').bind('ssSearchLoaded', function (e, answer) {
			if (undefined === answer[0] || true === autocompleteuser)
				return;

			if (true === answer[0].current) {
				$("#user input[name='user_id']").val(answer[0].id);
				$("#user #user_id .ss-search-select-result").val(answer[0].value);
				$("#user #user_enter").val('');

				autocompleteuser = true;
			}
		});
	});
</script><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/post/create-scripts.blade.php ENDPATH**/ ?>