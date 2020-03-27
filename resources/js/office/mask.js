function bindMask()
{
	$('*').each(function () {
		if (undefined === $(this).attr('data-mask'))
			return;

		// если бинда еще не было
		if (undefined === $(this).attr('data-mask-bind')) {
			// биндим
			$(this).mask($(this).attr('data-mask'));
			// отмечаем что бинд произошел
			$(this).attr('data-mask-bind', true);
		}
	});
}

$(document).ready(function () {
	bindMask();
});