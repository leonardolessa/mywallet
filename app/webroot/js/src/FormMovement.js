MW.components.FormMovement = function(settings) {
	this.init(settings);
}

MW.components.FormMovement.prototype = {
	init: function(settings) {
		this.settings = settings;

		this.setup();
		this.bind();
	},

	setup: function() {
		var dateElements = this.settings.form.find('.datepicker');

		this.settings.form.find('.switch').bootstrapSwitch();

		this.settings.form.find('.money').priceFormat({
			prefix: 'R$ '
		});

		this.settings.form.validate();

		dateElements.datepicker({
		    format: "dd/mm/yyyy",
		    language: "pt-BR",
		    autoclose: true,
		    todayHighlight: true
		});

		if(this.settings.action == 'add') {
			dateElements.datepicker('setDate', MW.i.movements.getDate());
		}
	},

	bind: function() {
		var self = this;

		this.settings.form.on('submit', function(ev) {
			ev.preventDefault();

			if($(this).valid()) {
				self.submitForm(ev.target);
			}
		});
	},

	submitForm: function(form) {
		var self = this,
			data = $(form).serialize(),	
			url = $(form).attr('action') + '.json';
			
		$.ajax({
			data: data,
			url: url,
			type: 'POST'
		}).done(function(data) {
			self.setMessage(data.message);
		});
	},

	setMessage: function(data) {
		if(data.type == 'error') {
			this.showErrors(data.errors);
		} else if (data.type == 'success') {
			this.showMessage(data.text);
			this.closeModal();
		}
	},

	showErrors: function(errors) {
		$.each(errors, function(index, value) {
			console.log(errors);
		});
	},

	showMessage: function(message) {
		var messageBox = $('.alert-on');

		messageBox.addClass('alert-success').html('<p>'+ message + '</p>').slideDown();
		
		setTimeout(function() {
			messageBox.slideUp();
		}, 3000);
	},

	closeModal: function() {
		this.settings.form.closest('.modal').modal('hide');
		this.refreshMovements();
	},

	refreshMovements: function() {
		MW.i.movements.getByMonth();
	}
}