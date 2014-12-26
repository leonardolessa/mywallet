MW.components.Categories = function(settings) {
	this.init(settings);
}

MW.components.Categories.prototype = {
	init: function(settings) {
		this.settings = this.getSettings(settings);

		this.getMovements();
		this.setup();
		this.bind();
	},

	getSettings: function(settings) {
		return $.extend({
			wrapper: $('.categories')
		}, settings);
	},

	
}