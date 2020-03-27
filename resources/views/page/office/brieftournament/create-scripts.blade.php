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

		$('#brief').bind('ssSearchEnter ssSearchDeSelect', function () {
			clearSelect('tournament');

			// запускаем релоад (запуская релоад сработает событие ssSearchLoad
			// для списка турниров)
			search_tournament_id.reLoad();
		});

		// событие перед выгрузкой списка турниров
		$('#tournament').bind('ssSearchLoad', function () {
			// получаем поле новостей
			var input = $("#brief input[name='brief_id']");

			// подставляем поле brief_id к запросу списка турниров
			if (input.val() != '')
				search_tournament_id.addField('brief_id', input.val());
		});
	});
</script>