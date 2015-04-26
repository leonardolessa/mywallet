
/**
 * Delegator
 * service responsable to delegate the demand to the components
 */
MW.services.Delegator = function() {

	/**
	 * delegate method
	 * the method that actually do the job
	 * @return void
	 */
	this.delegate = function() {
		var components = $('[data-component]');

		$.each(components, function(index, value) {
			var component = $(this).data('component');

			MW.i[component] = new MW.components[component]({
				wrapper: $(this),
				loader: $(this).find('.loader-wrapper'),
				output: $(this).find('tbody')
			});
		});
	}

	this.delegate();
}
