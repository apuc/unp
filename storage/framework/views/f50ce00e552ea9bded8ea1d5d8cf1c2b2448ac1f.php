<script>
	$(document).ready(function () {
		// событие перед выгрузкой списка юзеров
		$('#user').bind('ssSearchLoad', function () {
			search_user_id
				.addField('type', 'posts')
			;
		});
	});
</script><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/post/edit-scripts.blade.php ENDPATH**/ ?>