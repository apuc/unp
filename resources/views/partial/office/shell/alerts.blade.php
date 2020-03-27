<div id="notification-alert-template" class="hidden">
	<section class="content container-fluid">
		<div class="alert alert-notifications alert-info">
			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
			<div class="content"></div>
		</div>
	</section>
</div>



<div id="notification-alerts"></div>

<script>
	/**
	 * клик по кнопке "закрыть" для уведомлений
	 * о новых заявок
	 */

	$('body').bind('ss.notification.orders.button.click', function (e, message, i, registry) {
		$('#notification-alerts > section').eq(i).addClass('hidden');
		$.get(message.parameters.url, function (data) {
			registry.messages.types.orders.count = 0;
		});
	});

	/**
	 * происходит загрузка уведомлений
	 */

	$('body').bind('ss.notification.messages.load', function (e, messages, registry) {
		var types = registry.messages.types;

		/**
		 * функция заводит дефолтное значение для
		 * новый заказов в реестре
		 */

		var setDefaultOrdersCount = function () {
			var count = function () {
				for (var i in messages)
					if (messages[i].type == 'orders')
						return messages[i].parameters.count;

				return 0;
			};

			// если нет, типа "orders" в реестре
			if (undefined === types.orders)
				// создаем его и заполняем параметром "count"
				types.orders = {
					'count': count()
				};

			 // если в реестре есть тип "orders", но параметр "count" отсутсвует
			 else if (undefined === types.orders.count)
				// заполняем параметр "count"
				types.orders['count'] = count();
		};

		// устанавливаем дефолт значение для новых
		// заявок
		setDefaultOrdersCount();
	});

	/**
	 * происходит загрузка уведомления о новых заявках
	 */

	$('body').bind('ss.notification.orders.load', function (e, alert, message, i, registry) {
		var types = registry.messages.types;

		/**
		 * функция чистит звуковое сопровождение
		 * если оно есть
		 */

		var clear = function (message) {
			var msg = $('<div>' + message.value + '</div>');

			// если есть тег audio
			if (msg.find('audio').length > 0) {
				// удаляем его
				msg.find('audio').remove();
				message.value = msg.html();
			}
		};

		// если в реестре есть параметр "count" типа "orders"
		// сравниваем кол-ва. если присланное кол-во больше чем сохраненное
		if (parseInt(message.parameters.count) > parseInt(types.orders.count))
			// обновляем параметр "count"
			types.orders.count = message.parameters.count;

		// в остальных случаях
		else
			// чистим звуковое сопровоздение (если есть)
			clear(message);
	});

</script>

