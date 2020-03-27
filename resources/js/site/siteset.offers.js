var ssOffersVariable = null;

/**
 *
 *
 */

function ssOffers(type, scope)
{
	if (null === ssOffersVariable)
		ssOffersVariable = new ssOffersClass();

	ssOffersVariable
		.setType(null)
		.setScope(null)
	;

	if (undefined !== type)
		ssOffersVariable.setType(type);

	if (undefined !== scope)
		ssOffersVariable.setScope(scope);

	return ssOffersVariable;
}

/**
 *
 *
 *
 */

function ssOffersClass()
{
	/**
	 *
	 *
	 */

	var type = null;

	/**
	 *
	 *
	 */

	var scope = null;

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

		if ($(win).find("*[data-ss-offers-content]").length > 0)
			return;

		if ($(win).hasClass('ss-offers-busy'))
			return;

		$(win).addClass('ss-offers-busy');

		// перез загрузкой
		$(win).trigger('ss.offers.load', [self]);

		$.get(url + '/offers?type=' + type + '&scope=' + scope, {
			//
		}, function (content) {
			$(win).removeClass('ss-offers-busy');

			// после загрузки
			$(win).trigger('ss.offers.loaded', [self, content]);
		});
	};

	/**
	 *
	 *
	 */

	this.setType = function (t) {
		type = t;

		return self;
	};

	/**
	 *
	 *
	 */

	this.setScope = function (s) {
		scope = s;

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
	 *
	 *
	 */

	var self = this;
}