MW.components.WidgetOverview = function(settings) {
	this.init(settings);
}

MW.components.WidgetOverview.prototype = {
	init: function(settings) {
		this.settings = settings;

		this.loadContent();
	},

	setup: function(data) {
		var self = this;

		this.settings.loader.hide();

		Morris.Donut({
			element: self.settings.wrapper,
			data: [
				{value: data.expenses, label: 'Despesas'},
				{value: data.incoming, label: 'Receitas'},
			],
			labelColor: '#555',
			colors: [
				'red',
				'green'
			],
			resize: true,
			formatter: function (x) { return "R$ " + x}
		});
	},

	loadContent: function() {
		var self = this,
			url = this.settings.wrapper.data('url');

		$.ajax({
			url: url,
			type: 'GET'
		}).done(function(data) {
			if (data.overview.expenses || data.overview.incoming) {
				return self.setup(data.overview);
			}

			return self.setEmptyMessage();
		})
	},

	setEmptyMessage: function() {
		this.settings.loader.hide();
		this.settings.wrapper.append('<div class="empty-message"><p>Não há dados para gerar o gráfico.</p></div>')
	}
}
