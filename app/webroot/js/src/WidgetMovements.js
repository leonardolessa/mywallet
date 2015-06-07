MW.components.WidgetMovements = function(settings) {
	this.init(settings);
};

MW.components.WidgetMovements.prototype = {
	init: function(settings) {
		this.settings = settings;
		this.table = this.settings.wrapper.find('.table');


		this.settings.actionsUrl = this.settings.wrapper.find('.th-head-paid').data('url')
		this.settings.loader = this.settings.wrapper.find('.loader-wrapper');
		this.settings.output = this.settings.wrapper.find('tbody');

		this.bind();
		this.loadMovements();
	},

	repeat: function() {
		this.table.hide();
		this.settings.loader.show();

		if (this.datatable) {
			this.datatable.destroy();
		}

		this.settings.output.html('');

		this.loadMovements();
	},

	loadMovements: function() {
		var self = this,
			url = this.settings.wrapper.data('url');

		$.ajax({
			url: url,
			type: 'POST',
			data: {
				'data[Movement][late]': this.settings.late,
				'data[Movement][type]': this.settings.type
			},
		}).done(function(data) {
			if (data.movements.length > 0) {
				return self.populate(data.movements);
			}
			return self.setEmptyMessage();
		})
	},

	setEmptyMessage: function() {
		this.settings.output.html('<tr class="odd"><td valign="top" colspan="6" class="empty-line">Nenhum registro encontrado, <a href="'+ ROOTURL +'movements">clique aqui</a> para adicionar movimentações.</td></tr>');
		this.table.fadeIn();
		this.settings.wrapper.find('.loader-wrapper').hide();
	},

	bind: function() {
		var self = this;

		this.settings.output.on('click', '.paid-movement', function() {
			console.log('uihuisad')
			self.switchPaid(this);
		});
	},

	switchPaid: function(target) {
		var id = $(target).closest('tr').data('payment-id'),
			url = this.settings.actionsUrl,
			self = this;

		$.ajax({
			url: url + '/pay/' + id + '.json',
			type: 'GET'
		}).done(function() {
			self.repeat();
		});
	},

	populate: function(data) {
		var self = this;

		this.results = data.length;

		$.each(data, function(index) {
			self.renderMovement(this);
		});

		this.settings.loader.hide();
		this.table.show();

		this.setup();
	},

	setup: function() {
		this.settings.output.find('.money').priceFormat({
			prefix: 'R$ '
		});


		this.datatable = this.settings.wrapper.find('table').DataTable({
			aoColumnDefs: [{
				bSortable: false,
				aTargets: ['no-sort']
			}],
			language: {
			  "sSearch": " ",
			  "sZeroRecords": "Nenhum registro encontrado",
			  paginate: {
			  	previous: 'Anterior',
			  	next: 'Próximo'
			  }
			},
			paging: this.results > 3 ? true : false,
			info: false,
			searching: false,
			lengthChange: false,
			pageLength: 3,
			pagingType: 'simple',
			classes: {
				sFilterInput: 'input-sm form-control search-movements'
			}
		});
	},

	renderMovement: function(element) {
		var html = [],
			icon = this.checkType(element.Movement.type),
			paid = this.checkPaid(element.Payment.paid);


		html.push('	<tr data-movement-id="'+ element.Movement.id +'" data-payment-id="'+ element.Payment.id +'">');
		html.push('		<td>'+ element.Payment.date +'</td>')
		html.push('		<td>'+ element.Movement.description +'</td>')
		html.push('		<td><span class="glyphicon glyphicon-stop" style="color: '+ element.Movement.Category.color +';"></span>'+ element.Movement.Category.name +'</td>');
		html.push('		<td class="money">'+ element.Payment.amount +'</td>')
		html.push('		<td><a href="javascript:;" class="paid-movement" data-paid="'+ element.Payment.paid +'" data-toggle="tooltip" title="Clique para alterar se está pago.">'+ paid +'</a></td>');
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
