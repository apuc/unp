/**
 *
 * @version 1.1
 */

$(document).ready(function () {
	/**
	 * приватное свойство хоторое хранит некую инфу
	 * для передачи е между уведомлениями
	 */

	var registry = {
		'counters': {
			'types': {}
		},
		'messages': {
			'types': {}
		}
	};

	/**
	 * функция загрузчик
	 *
	 */

	var load = function () {
		$.get('/admin/ajax/notifications', function (data) {

			/**
			 * функция устновки счетчика
			 *
			 */

			var setCounter = function (counter) {

				var badge = $('#notification-' + counter.type + ' .notification-badge');

				if (0 === badge.length)
					return;

				// запускаем событие "загрузка счетчика"
				$('body').trigger('ss.notification.' + counter.type +'.load', [badge, counter, i, registry]);

				badge.text(counter.value);

				// запускаем событие "загрузка счетчика завершена"
				$('body').trigger('ss.notification.' + counter.type +'.loaded', [counter, i, registry]);
			}

			/**
			 * функция устновки сообщения
			 *
			 */

			var setMessage = function (message, i) {
				var alert = $($('#notification-alert-template').html());

				// запускаем событие "загрузка сообщения"
				$('body').trigger('ss.notification.' + message.type +'.load', [alert, message, i, registry]);

				alert.find('.content').html(message.value);
				alert.find("button[type='button']").bind('click', function () {
					$('body').trigger('ss.notification.' + message.type +'.button.click', [message, i, registry]);
				});

				$('#notification-alerts').append(alert);

				// запускаем событие "загрузка сообщения завершена"
				$('body').trigger('ss.notification.' + message.type +'.loaded', [message, i, registry]);
			}

			// счетчики
			// запускаем событие "происходит загрузка счетчиков"
			$('body').trigger('ss.notification.counters.load', [data.counters, registry]);

			for (var i in data.counters)
				setCounter(data.counters[i]);

			// запускаем событие "загрузка счетчиков завершена"
			$('body').trigger('ss.notification.counters.loaded', [data.counters, registry]);

			// сообщения
			// запускаем событие "происходит загрузка сообщений"
			$('body').trigger('ss.notification.messages.load', [data.messages, registry]);

			// удаляем сообщения
			$('#notification-alerts').html('');
			for (var i in data.messages)
				setMessage(data.messages[i], i);

			// запускаем событие "загрузка сообщений завершена"
			$('body').trigger('ss.notification.messages.loaded', [data.messages, registry]);

		}, 'json');
	};

	/**
	 * перезагрузка загрузчика
	 *
	 */

	setInterval(function () {
		load();
	}, 60000);

	/**
	 * стартовый загрузчик
	 *
	 */

	load();
});
