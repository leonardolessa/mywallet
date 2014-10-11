MW.components.Movements = function(settings) {
	this.init(settings);
}

MW.components.Movements.prototype = {
	init: function(settings) {
		this.settings = settings;

		this.getMovements();
		this.bind();
	},

	getMovements: function() {
		var self = this;

		$.ajax({
			url: this.settings.wrapper.data('url') + '.json',
			type: 'GET',
			dataType: 'json',
		}).done(function(data) {
			self.loadContent(data.movements);
		});
	},	

	loadContent: function(data) {
		var self = this;

		this.settings.wrapper.hide();
		this.settings.loader.show();
		
		$.each(data, function(index, value) {
			self.addMovement(value, function() {
				self.settings.wrapper.show();
				self.settings.loader.hide();
			});
		});
	},

	addMovement: function(element, callback) {
		var html = [],
			icon;

		if(element.Movement.type) {
			icon = '<span class="glyphicon glyphicon-upload"></span>';
		} else {
			icon = '<span class="glyphicon glyphicon-download"></span>';
		}

		html.push('	<tr>');
		html.push('		<td class="td-type">');
		html.push(			icon);
		html.push('		</td>')
		html.push('		<td>'+ element.Movement.date +'</td>')
		html.push('		<td>'+ element.Movement.description +'</td>')
		html.push('		<td><span class="glyphicon glyphicon-stop" style="color: #'+ element.Category.color +';"></span>'+ element.Category.name +'</td>');
		html.push('		<td>'+ element.Movement.amount +'</td>')
		html.push('		<td>');
		html.push('			<span class="glyphicon glyphicon-thumbs-up"></span>');
		html.push('			<span class="glyphicon glyphicon-edit"></span>');
		html.push('			<span class="glyphicon glyphicon-trash"></span>');
		html.push('		</td>');
		html.push('</tr>');

		this.settings.output.append(html.join(''));

		if(callback) {
			callback();
		}
	},

	// requestData: function(callback, data) {
	// 	var url = this.settings.wrapper.data('url'),
	// 		data = data || {};

	// 	$.ajax({
	// 		url: url,
	// 		data: data,
	// 		type: 'POST',
	// 	}).done(function(data) {

	// 	})
	// },

	bind: function() {
		
	}
}