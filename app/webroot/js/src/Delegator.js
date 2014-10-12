
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
			/**
			 * Define the components inside the case
			 */
			switch(component) {
				case 'movements':
					MW.i.movements = new MW.components.Movements({
						wrapper: $(this),
						loader: $('.loader-wrapper'),
						output: $(this).find('tbody')
					});
					break;
			}
		});
	}

	this.delegate();
}