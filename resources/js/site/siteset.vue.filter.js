/**
 * класс позволяет работать с фильтром
 * на фронденде
 *
 * @name SiteSet Vue Filter JS
 * @version 0.0.1
 * @author Alexey Glumov
 * @copyright Copyright (c) 2018 SoftArt Internet Company http://softart.ru
 */

/**
 * класс фильтра
 *
 */

function ssVueFilterClass()
{
	/**
	 * данные
	 *
	 * @var mixed
	 */

	this.data;

	/**
	 * доп данные
	 *
	 * @var mixed
	 */

	this.options = {};

	/**
	 * блоки
	 *
	 * @var array
	 */

	this.blocks = [];

	/**
	 * урл где хранятся компоненты
	 *
	 * @var string
	 */

	this.components;

	/**
	 * префикс
	 *
	 * @var string
	 */

	var name = 'ss-vue-filter';

	/**
	 * ссылка на класс ssVueFilterClass
	 *
	 * @var ssVueFilterClass
	 */

	var self = this;

	/**
	 *
	 *
	 */

	this.load = function () {
		$.get(self.components, {}, function(answer) {
			var content = $(answer);

			for (var i in self.blocks)
				if ($('#' + name + '-load-' + self.blocks[i]).length > 0)
					$('#' + name + '-load-' + self.blocks[i]).replaceWith(
						content.find('#' + name + '-load-' + self.blocks[i]).html()
					);

			init();

			$('body').trigger('ss.loaded.vue-filter', [self]);

		}, 'html');
	};


	/**
	 *
	 *
	 */

	var init = function () {
		for (var i in self.blocks)
			if ($('#' + name + '-el-' + self.blocks[i]).length > 0)
				new Vue({

					/**
					 * элемент
					 *
					 */

					el: '#' + name + '-el-' + self.blocks[i],

					/**
					 * данные
					 *
					 */

					data: {
						/**
						 * основные данные
						 *
						 */

						data: self.data,

						/**
						 * вспомогательные данные
						 *
						 */

						options: self.options
					},

					/**
					 * хук перед монтированием
					 * приложения
					 *
					 */

					beforeMount: function () {
						var pattern	= new RegExp('^' + name + '\-el\-(.*)$');
						var block	= $(this.$el).attr('id').match(pattern)[1];
						$('body').trigger('ss.' + block + '.beforemount.vue-filter', [self, this.options]);
					},

					/**
					 * хук после обновления
					 * приложения
					 *
					 */

					updated: function () {
						var pattern	= new RegExp('^' + name + '\-el\-(.*)$');
						var block	= $(this.$el).attr('id').match(pattern)[1];
						$('body').trigger('ss.' + block + '.updated.vue-filter', [self]);
					},

					methods: {

						/**
						 * существуют ли данные
						 *
						 * @return boolean
						 *
						 * @param string property
						 */

						has: function (property) {
							return !$.isEmptyObject(self.data[property]);
						}
					}
				});
	};
}

/**
 * переменная для хранения объекта
 * класса ssVueFilterClass
 *
 * @var ssVueFilterClass
 */

var ssVueFilterVariable = null;

/**
 * быстрый доступ к объекту класса
 * ssVueFilterClass
 *
 * @return ssVueFilterClass
 *
 * @param object options настройки
 */

function ssVueFilter(options)
{
	if (null === ssVueFilterVariable)
		ssVueFilterVariable = new ssVueFilterClass();

	if (undefined !== options && undefined !== options.data)
		ssVueFilterVariable.data = JSON.parse(options.data);

	if (undefined !== options && undefined !== options.blocks)
		ssVueFilterVariable.blocks = options.blocks;

	if (undefined !== options && undefined !== options.components)
		ssVueFilterVariable.components = options.components;

	return ssVueFilterVariable;
}