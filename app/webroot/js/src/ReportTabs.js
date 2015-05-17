MW.components.ReportTabs = function(settings) {
	this.init(settings);
};

MW.components.ReportTabs.prototype = {
	init: function(settings) {
		this.settings = settings;

		this.settings.loader = this.settings.wrapper.find('.loader-wrapper');
		this.setup();
	},

	setup: function() {
		var self = this,
			categoriesList = this.settings.wrapper.find('.categories-list'),
			url = categoriesList.data('url');

		$.ajax({
			url: url,
			type: 'GET'
		}).done(function(data) {
			self.renderList(data.categories, function() {
				self.bind();
			});
		})
	},

	bind: function() {
		var self = this,
			reportTabs = this.settings.wrapper.find('[data-toggle="reportGeneral"]'),
			reportCat = this.settings.wrapper.find('[data-toggle="reportCat"]');

		reportTabs.on('click', function() {
			var _this = $(this);

			if (!_this.parent().hasClass('active')) {
				self.getReportData(_this);
			}
		});

		reportCat.on('click', function() {
			var _this = $(this);

			if (!_this.parent().hasClass('active')) {
				self.getReportData(_this);
			}
		})

		reportTabs.trigger('click');
	},

	getReportData: function(el) {
		var self = this,
			url;

		if (el.data('category-id')) {
			url = this.settings.wrapper.data('url') + '/' + el.data('category-id') + '.json';
			console.log(url);
		} else {
			url = this.settings.wrapper.data('url') + '.json';
		}

		$.ajax({
			url: url,
			type: 'GET'
		}).done(function(data) {
			el.tab('show');
			self.setupGraphic(data, el, function() {
				self.settings.loader.fadeOut();
			});
		});
	},

	setupGraphic: function(data, el, callback) {
		var	self = this,
			context = jQuery(el.attr('href')),
			graphic = context.find('.graphic');

		graphic.html('');

		Morris.Line({
			element: graphic,
			data: data.report,
			xkey: 'date',
			ykeys: ['incoming', 'expenses'],
			labels: ['Receitas', 'Despesas'],
			xLabels: 'month',
			lineColors: ['#008000', '#FF0000'],
			dateFormat: function(date) {
				return self.formatDate(date);
			},
			xLabelFormat: function(date) {
				return self.formatDate(date);
			},
			preUnits: 'R$ ',
			resize: true
		});

		if (callback) {
			callback();
		}
	},

	formatDate: function(date) {
		var d = new Date(date);
		return (d.getMonth() + 1) + '/' + d.getFullYear();
	},

	renderList: function(data, callback) {
		var self = this;

		$.each(data, function(index, value) {
			self.renderElement(value.Category);
		});

		if (callback) {
			callback();
		}
	},

	renderElement: function(el) {
		var categoriesList = this.settings.wrapper.find('.categories-list'),
			html = [];

		html.push('<li>');
		html.push('		<a href="#categories" data-toggle="reportCat" data-category-id="'+ el.id +'">'+ el.name +'</a>');
		html.push('</li>');

		categoriesList.append(html.join(''));
	}
};
// $('[data-toggle="tabajax"]').click(function(e) {
//     var $this = $(this),
//         loadurl = $this.attr('href'),
//         targ = $this.attr('data-target');

//     $.get(loadurl, function(data) {
//         $(targ).html(data);
//     });

//     $this.tab('show');
//     return false;
// });
