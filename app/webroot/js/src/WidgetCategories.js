MW.components.WidgetCategories = function(settings) {
	this.init(settings);
};

MW.components.WidgetCategories.prototype = {
	init: function(settings) {
		this.settings = settings;

		this.table = this.settings.wrapper.find('.table');
		this.loadCategories();
	},

	loadCategories: function() {
		var self = this,
			url = this.settings.wrapper.data('url');

		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(data) {
			self.populate(data.categories);
		})
	},

	populate: function(data) {
		var self = this;

		$.each(data, function(index) {
			self.renderCategory(this);

			return index < 2;
		});

		this.settings.loader.hide();
		this.table.show();
	},

	renderCategory: function(category) {
		var html = [];

		html.push('	<tr data-category-id="' + category.Category.id + '">');
		html.push('		<td>');
		html.push('			<span class="glyphicon glyphicon-stop" style="color: ' + category.Category.color + ';"></span>');
		html.push('		</td>');
		html.push('		<td>');
		html.push('		' + category.Category.name);
		html.push('		</td>');
		html.push('	</tr>');

		this.settings.output.append(html.join(''));
	}
};
