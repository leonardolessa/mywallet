MW.components.Categories = function(settings) {
	this.init(settings);
}

MW.components.Categories.prototype = {
	init: function(settings) {
		this.settings = this.getSettings(settings);

		this.getCategories();
		this.bind();
	},

	bind: function() {
		var self = this;

		this.settings.output.on('click', '.delete-category', function() {
			if(confirm('Você tem certeza que deseja excluir esta categoria?')) {
				self.deleteCategory(this);
			}
		});
	},

	getSettings: function(settings) {
		return $.extend({
			wrapper: $('.categories'),
			actionsUrl: $('.th-head-actions').data('url')
		}, settings);
	},

	getCategories: function() {
		var self = this;

		$.ajax({
			url: this.settings.wrapper.data('url'),
			type: 'GET'
		}).done(function(data) {
			if (data.categories.length > 0) {
				return self.loadContent(data.categories, function() {
					self.settings.loader.hide();
					self.settings.wrapper.find('.panel').fadeIn();
				});
			}

			return self.setEmptyMessage();
		})
	},

	setEmptyMessage: function() {
		this.settings.output.html('<tr class="odd"><td valign="top" colspan="3" class="empty-line">Nenhum registro encontrado.</td></tr>');
		this.settings.wrapper.find('.panel').fadeIn();
		this.settings.wrapper.find('.loader-wrapper').fadeOut();
	},

	loadContent: function(categories, callback) {
		var self = this
			callback = callback || function() {};

		this.settings.output.html('');

		if(categories.length > 0) {
			$.each(categories, function() {
				self.renderCategory(this);
			});
		}

		callback();
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
		html.push('		<td>');
		html.push('			<a href="' + this.settings.actionsUrl + '/edit/' + category.Category.id + '" data-toggle="modal" data-target=".modal-categories" class="edit-categories" title="Clique para editar essa categoria>">');
		html.push('				<span class="glyphicon glyphicon-edit"></span>');
		html.push('			</a>');
		html.push('			<a href="javascript:;" class="delete-category">');
		html.push('				<span class="glyphicon glyphicon-trash"></span>');
		html.push('			</a>');
		html.push('		</td>');
		html.push('	</tr>');

		this.settings.output.append(html.join(''));
	},

	deleteCategory: function(target) {
		var id = $(target).closest('tr').data('category-id'),
			url = this.settings.actionsUrl,
			self = this;


		$.ajax({
			url: url + '/' + id + '.json',
			type: 'DELETE'
		}).done(function(data) {
			self.getCategories();
		});
	},


}
