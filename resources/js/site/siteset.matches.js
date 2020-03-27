var ssMatchesVariable = null;

/**
 *
 *
 */

function ssMatches(tournament_id)
{
	if (null === ssMatchesVariable)
		ssMatchesVariable = new ssMatchesClass();

	ssMatchesVariable.setTournament(null);

	if (undefined !== tournament_id)
		ssMatchesVariable.setTournament(tournament_id);

	return ssMatchesVariable;
}

/**
 *
 *
 *
 */

function ssMatchesClass()
{
	/**
	 *
	 *
	 */

	var tournament_id = null;

	/**
	 *
	 *
	 */

	var url = null;

	/**
	 *
	 *
	 */

	this.load = function (win) {

		if ($(win).find("*[data-ss-matches-content]").length > 0)
			return;

		if ($(win).hasClass('ss-matches-busy'))
			return;

		$(win).addClass('ss-matches-busy');

		// перез загрузкой
		$(win).trigger('ss.matches.load', [self]);

		$.get(getUrl(), {
			//
		}, function (content) {
			$(win).removeClass('ss-matches-busy');

			// после загрузки
			$(win).trigger('ss.matches.loaded', [self, content]);
		});
	};

	/**
	 *
	 *
	 */

	this.setTournament = function (value) {
		tournament_id = value;

		return self;
	};

	/**
	 *
	 *
	 */

	this.setUrl = function (str) {
		url = str;

		return self;
	};

	/**
	 * метод возвращает полный урл для
	 * перезагрузки страницы
	 *
	 * @retrun string
	 */

	var getUrl = function () {
		var parameters = [];

		parameters.push({
			parameter:	'tournament_id',
			value:		tournament_id
		});

		$("*").each(function () {
			var parameter = $(this).attr('data-ss-pn-parameter');

			// если у блока нет атрибута "параметр"
			if (undefined === parameter)
				// выходим
				return;

			// если перед нами список
			if ($(this)[0].tagName === 'SELECT')
				parameters.push({
					parameter:	parameter,
					value:		$(this).val()
				});

			else if ($(this)[0].tagName === 'INPUT')
				switch($(this).attr('type')) {
					case 'checkbox':
					case 'radio':
						if (true === $(this).prop('checked'))
							parameters.push({
								parameter:	parameter,
								value:		$(this).val()
							});
						break;

					default:
						parameters.push({
							parameter:	parameter,
							value:		$(this).val()
						});
						break;
				}
		});

		var result = url;

		if (parameters.length > 0) {
			var hash = [];
			for (var i in parameters)
				hash.push(''
					+ parameters[i].parameter
					+ '='
					+ parameters[i].value
				);

			result += '?' + hash.join('&');
		}

		return result;
	}

	/**
	 *
	 *
	 */

	var self = this;
}