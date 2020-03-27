function ssSM()
{
	this.toggle = function (a) {

		var ul = a.parents('li').eq(0).find('> ul');

		if (ul.hasClass('hidden')) {
			ul			.removeClass('hidden');
			a.find('i')	.removeClass('fa-plus');
			a.find('i')	.addClass('fa-minus');
		}
		else {
			ul			.addClass('hidden');
			a.find('i')	.removeClass('fa-minus');
			a.find('i')	.addClass('fa-plus');
		}
	};
}

var sitemap = new ssSM();