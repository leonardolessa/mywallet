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
		this.settings.form.find('.switch').bootstrapSwitch();
	},

	bind: function() {
		var self = this;

		this.settings.form.on('submit', function(ev) {
			ev.preventDefault();
			self.submitForm(ev.target);
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
				self.setMessage(data);
			});
	},

	setMessage: function(data) {
		if(data.type == 'error') {
			this.showErrors(data.errors);
		} else if (data.type == 'success') {
			this.showMessage(data.message);
		}
	},

	showErrors: function(errors) {
		$.each(errors, function(index, value) {
			console.log(errors);
		});
	},

	showMessage: function(message) {
		console.log(message);
	}
}