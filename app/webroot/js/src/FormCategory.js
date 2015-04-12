MW.components.FormCategory = function(settings) {
	this.init(settings);
}

MW.components.FormCategory.prototype = {
	init: function(settings) {
		this.settings = this.getSettings(settings);

		this.setup();
		this.bind();
	},

	getSettings: function(settings) {
		return $.extend({
			form: $('.form-category-add'),
			action: 'add'
		}, settings);
	},

	setup: function() {
		this.colorpicker = this.settings.form.find('.color-picker');

		this.colorpicker.colorpicker({
			component: '.input-group-addon'
		});
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
			console.log(data);
			self.setMessage(data.message);
		});
	},

	setMessage: function(data) {
		if(data.type == 'error') {
			this.showErrors(data.errors);
		} else if (data.type == 'success') {
			this.showMessage(data.text);
			this.closeModal();
			MW.i.categories.getCategories();
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
	}
}
