MW.components.Movements = function(settings) {
	this.init(settings);
}

MW.components.Movements.prototype = {
	init: function(settings) {
		this.settings = this.getSettings(settings);

		this.getMovements();
		this.setup();
		this.bind();
	},

	getSettings: function(settings) {
		return $.extend({
			wrapper: $('.movements'),
			loader: $('.loader-wrapper'),
			output: $('.movements').find('tbody'),
			nextButton: $('.movements').find('.next'),
			previousButton: $('.movements').find('.previous'),
			pagination: $('.movements').find('.pagination'),
			actionsUrl: $('.th-head-actions').data('url')
		}, settings);
	},

	setup: function() {
		this.settings.output.find('.money').priceFormat({
			prefix: 'R$ '
		});
	},

	getDate: function() {
		return new Date(this.currentYear, this.currentMonth, new Date().getDate());
	},

	bind: function() {
		var self = this;

		this.settings.nextButton.on('click', function() {
			self.getNextMonth();
		});

		this.settings.previousButton.on('click', function() {
			self.getPreviousMonth();
		});

		this.settings.output.on('click', '.delete-movement', function() {
			if(confirm('Tem certeza que deseja excluir essa movimentação?')) {
				self.deleteMovement(this);	
			}
		});

		this.settings.output.on('click', '.paid-movement', function() {
			self.switchPaid(this);
		});	
	},

	getPreviousMonth: function() {
		if(this.currentMonth > 0) {
			this.currentMonth--;
		} else if (this.currentMonth == 0) {
			this.currentMonth = 11;
			this.currentYear--;
		}
		this.getByMonth();
	},

	getNextMonth: function() {
		if(this.currentMonth < 11) {
			this.currentMonth++;
		} else if (this.currentMonth == 11) {
			this.currentMonth = 0;
			this.currentYear++;
		}
		this.getByMonth();
	},

	switchPaid: function(target) {
		var id = $(target).closest('tr').data('movement-id'),
			url = this.settings.actionsUrl,
			self = this;

		$.ajax({
			url: url + '/pay/' + id + '.json',
			type: 'GET'
		}).done(function() {
			self.getByMonth();
		});
	},

	deleteMovement: function(target) {
		var id = $(target).closest('tr').data('movement-id'),
			url = this.settings.actionsUrl,
			self = this;

		$.ajax({
			url: url + '/' + id + '.json',
			type: 'DELETE'
		}).done(function() {
			self.getByMonth();
		});
	},

	setPaginator: function() {
		var title = this.settings.pagination.find('.current'),
			months = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

		title.find('.month').html(months[this.currentMonth]);
		title.find('.year').html(this.currentYear);
	},

	getByMonth: function() {
		var self = this,
			url = this.settings.pagination.data('url');

		this.settings.wrapper.hide();
		this.settings.loader.show();
		this.setPaginator();

		$.ajax({
			url: url,
			type: 'POST',
			data: {
				Movement: {
					month: this.currentMonth + 1,
					year: this.currentYear
				}
			}
		}).done(function(data) {
			self.loadContent(data.movements);
		});
	},

	getMovements: function() {
		var self = this;

		this.settings.wrapper.hide();
		this.settings.loader.show();

		$.ajax({
			url: this.settings.wrapper.data('url'),
			type: 'GET',
		}).done(function(data) {
			self.getCurrentDate(data.date);
			self.loadContent(data.movements);
		});
	},

	getCurrentDate: function(date) {
		this.currentMonth = new Date(date).getMonth();
		this.currentYear = new Date(date).getFullYear();
		this.setPaginator();
	},	

	loadContent: function(movements) {
		var self = this;

		this.settings.output.html('');

		if(movements.length > 0) {
			$.each(movements, function(index, value) {
				self.renderMovement(value, function() {
					self.settings.wrapper.show();
					self.settings.loader.hide();
				});
			});
		} else {
			this.settings.loader.hide();
			this.settings.wrapper.show();
		}

		this.setup();
	},

	renderMovement: function(element, callback) {
		var html = [],
			icon = this.checkType(element.Movement.type),
			paid = this.checkPaid(element.Movement.paid);

		html.push('	<tr data-movement-id="'+ element.Movement.id +'">');
		html.push('		<td class="td-type">');
		html.push(			icon);
		html.push('		</td>')
		html.push('		<td>'+ element.Movement.date +'</td>')
		html.push('		<td>'+ element.Movement.description +'</td>')
		html.push('		<td><span class="glyphicon glyphicon-stop" style="color: #'+ element.Category.color +';"></span>'+ element.Category.name +'</td>');
		html.push('		<td class="money">'+ element.Movement.amount +'</td>')
		html.push('		<td><a href="javascript:;" class="paid-movement" data-paid="'+ element.Movement.paid +'" data-toggle="tooltip" title="Clique para alterar se está pago.">'+ paid +'</a></td>');
		html.push('		<td class="td-actions">');
		html.push('			<a href="'+ this.settings.actionsUrl + '/edit/' + element.Movement.id +'" data-toggle="modal" data-target=".modal-movements" class="edit-movement" title="Clique para editar essa movimentação."><span class="glyphicon glyphicon-edit"></span></a>');
		html.push('			<a href="javascript:;" class="delete-movement" title="Clique para excluir essa movimentação."><span class="glyphicon glyphicon-trash"></span></a>');
		html.push('		</td>');
		html.push('</tr>');

		this.settings.output.append(html.join(''));

		if(callback) {
			callback();
		}
	},

	checkPaid: function(paid) {
		if(paid) {
			return '<span class="glyphicon glyphicon-thumbs-up"></span>'
		} 
		return '<span class="glyphicon glyphicon-thumbs-down"></span>'
	},

	checkType: function(type) {
		if(type) {
			return '<span title="Receita" class="glyphicon glyphicon-upload"></span>';
		}
		return '<span title="Despesa" class="glyphicon glyphicon-download"></span>';
	}
}