MW.components.Movements = function(settings) {
	this.init(settings);
}

MW.components.Movements.prototype = {
	init: function(settings) {
		this.settings = this.getSettings(settings);

		this.incoming = 0;
		this.expenses = 0;

		this.getMovements();
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
			actionsUrl: $('.th-head-actions').data('url'),
			balance: $('.balance-wrapper')
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
		var id = $(target).closest('tr').data('payment-id'),
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
		var id = $(target).closest('tr').data('payment-id'),
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
			self.updateBalance(data.balance);
			self.loadContent(data.payments);
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
			self.updateBalance(data.balance);
			self.getCurrentDate(data.date);
			self.loadContent(data.payments);
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

		if (movements.length > 0) {
			$.each(movements, function(index, value) {
				self.renderMovement(value);
				self.sumBalance(value);
			});
		}

		this.setBalanceValues();

		self.settings.loader.hide();
		self.settings.wrapper.show();

		this.setup();
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
		html.push('		<td><a href="javascript:;" class="paid-movement" data-paid="'+ element.Payment.paid +'" data-toggle="tooltip" title="Clique para alterar se está pago.">'+ paid +'</a></td>');
		html.push('		<td class="td-actions">');
		html.push('			<a href="/mywallet/payments/edit/' + element.Payment.id +'" data-toggle="modal" data-target=".modal-movements" class="edit-movement" title="Clique para editar essa movimentação."><span class="glyphicon glyphicon-edit"></span></a>');
		html.push('			<a href="javascript:;" class="delete-movement" title="Clique para excluir essa movimentação."><span class="glyphicon glyphicon-trash"></span></a>');
		html.push('		</td>');
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
			return '<span title="Receita" class="glyphicon glyphicon-upload"></span>';
		}
		return '<span title="Despesa" class="glyphicon glyphicon-download"></span>';
	},

	updateBalance: function(balance) {
		var totalElement = this.settings.balance.find('.total-balance');

		this.expenses = 0;
		this.incoming = 0;
		if (balance) {
			totalElement.html(balance.total);
			this.settings.balance.show();

			totalElement.priceFormat({
				prefix: 'R$ ',
				allowNegative: true
			});

			if (balance.positive) {
				totalElement.addClass('positive');
			} else {
				totalElement.removeClass('positive');
			}
		}
	},

	sumBalance: function(element) {
		if (element.Payment.paid) {
			if (element.Movement.type == 0) {
				this.expenses =+ element.Payment.amount;
			} else {
				this.incoming =+ element.Payment.amount;
			}
		}
	},

	setBalanceValues: function() {
		var monthBalance = this.settings.balance.find('.total'),
			totalIncoming = this.settings.balance.find('.total-incoming'),
			totalExpenses = this.settings.balance.find('.total-expenses');

		if (this.incoming >= this.expenses) {
			monthBalance.addClass('positive');
		} else {
			monthBalance.removeClass('positive');
		}

		monthBalance.html(parseFloat(this.incoming - this.expenses).toFixed(2));
		totalIncoming.html(parseFloat(this.incoming).toFixed(2));
		totalExpenses.html(parseFloat(this.expenses).toFixed(2));

		jQuery(monthBalance).add(totalIncoming).add(totalExpenses).priceFormat({
			prefix: 'R$ ',
			allowNegative: true
		});
	}
}
