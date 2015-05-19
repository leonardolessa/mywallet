MW.components.WidgetMovements = function(settings) {
	this.init(settings);
};

MW.components.WidgetMovements.prototype = {
	init: function(settings) {
		this.settings = settings;
		this.table = this.settings.wrapper.find('.table');

		this.loadMovements();
	},

	loadMovements: function() {
		var self = this,
			url = this.settings.wrapper.data('url');

		$.ajax({
			url: url,
			type: 'GET',
		}).done(function(data) {
			if (data.payments > 0) {
				return self.populate(data.payments);
			}
			return self.setEmptyMessage();
		})
	},

	setEmptyMessage: function() {
		this.settings.output.html('<tr class="odd"><td valign="top" colspan="6" class="empty-line">Nenhum registro encontrado, <a href="'+ ROOTURL +'movements">clique aqui</a> para adicionar movimentações.</td></tr>');
		this.table.fadeIn();
		this.settings.wrapper.find('.loader-wrapper').hide();
	},

	populate: function(data) {
		var self = this;

		$.each(data, function(index) {
			self.renderMovement(this);

			return index < 2;
		});

		this.settings.loader.hide();
		this.table.show();

		this.setup();
	},

	setup: function() {
		this.settings.output.find('.money').priceFormat({
			prefix: 'R$ '
		});
	},

	renderMovement: function(element) {
		var html = [],
			icon = this.checkType(element.Movement.type),
			paid = this.checkPaid(element.Payment.paid);

		html.push('	<tr data-movement-id="'+ element.Movement.id +'" data-payment-id="'+ element.Payment.id +'">');
		html.push('		<td class="td-type">');
		html.push(			icon);
		html.push('		</td>')
		html.push('		<td>'+ element.Payment.date +'</td>')
		html.push('		<td>'+ element.Movement.description +'</td>')
		html.push('		<td><span class="glyphicon glyphicon-stop" style="color: '+ element.Movement.Category.color +';"></span>'+ element.Movement.Category.name +'</td>');
		html.push('		<td class="money">'+ element.Payment.amount +'</td>')
		html.push('		<td>'+ paid +'</td>');
		html.push('</tr>');

		this.settings.output.append(html.join(''));
	},

	checkPaid: function(paid) {
		if(paid == 1) {
			return '<span class="glyphicon glyphicon-thumbs-up"></span>'
		}
		return '<span class="glyphicon glyphicon-thumbs-down"></span>'
	},

	checkType: function(type) {
		if(type == 1) {
			return '<span title="Receita" class="glyphicon glyphicon-upload">' + type + '</span>';
		}
		return '<span title="Despesa" class="glyphicon glyphicon-download">' + type + '</span>';
	},
};
