/**
 *
 *
 */

function ssProfits(url, year)
{
	return new ssProfitsClass(url, year);
}

/**
 *
 *
 *
 */

function ssProfitsClass(url, year)
{
	/**
	 *
	 *
	 */

	this.load = function () {
		var box	= $("*[data-ss-profits-content]");

		if (box.hasClass('ss-profits-busy'))
			return;

		box.addClass('ss-profits-busy');

		$('*[data-ss-profits-content]').fadeTo(0, 0.2, function() {

			box.html('<p class="text-center pb-2 pt-3">Загрузка...</p>');

			$.get(url, {'year': year}, function (content) {
				content = $('<div>' + content + '</div>');

				box.removeClass('ss-profits-busy');

				box.replaceWith(content.find("*[data-ss-profits-content]"));

				$('*[data-ss-profits-content]').fadeTo(0, 1.0);

			}, 'html');
		});
	};

	/**
	 *
	 *
	 */

	var self = this;
}