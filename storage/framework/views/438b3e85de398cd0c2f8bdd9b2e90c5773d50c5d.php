<script>
	$(document).ready(function () {
		// функция сброса выбранного пункта
		var clearSelect = function (entity) {
			// чистим выбранный пункт
			$("#" + entity +" input[name='" + entity + "_id']").val('');
			$("#" + entity + " #" + entity + "_id .ss-search-select-result").val('');
			$("#" + entity + " #" + entity + "_enter").val('');

			// запускаем событие "выбрали пустое значение"
			$('#' + entity).trigger('ssSearchDeSelect');
		};

		$('#post').bind('ssSearchEnter ssSearchDeSelect', function () {
			clearSelect('tournament');

			// запускаем релоад (запуская релоад сработает событие ssSearchLoad
			// для списка турниров)
			search_tournament_id.reLoad();
		});

		// событие перед выгрузкой списка турниров
		$('#tournament').bind('ssSearchLoad', function () {
			// получаем поле статей
			var input = $("#post input[name='post_id']");

			// подставляем поле post_id к запросу списка турниров
			if (input.val() != '')
				search_tournament_id.addField('post_id', input.val());
		});
	});
</script><?php /**PATH /var/www/sportliga/site/sportliga.com/resources/views/page/office/posttournament/create-scripts.blade.php ENDPATH**/ ?>