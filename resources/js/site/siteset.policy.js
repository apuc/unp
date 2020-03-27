function ssCheckPolicy(event, form, func) {

	form.find('.policy-error').css('display', '');
	event = event || window.event;

	if (false === form.find('.policy-check').prop('checked')) {
		form.find('.policy-error').css('display', 'block');

		if (event.preventDefault)
			event.preventDefault();

		else // иначе вариант IE8-:
			event.returnValue = false;

		return;
	}

	if (undefined !== func)
		func(event);
}