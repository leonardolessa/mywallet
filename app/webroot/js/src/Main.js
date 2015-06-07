$(document).ready(function() {
	MW.i.delegator = new MW.services.Delegator();

	$('body').on('hidden.bs.modal', '.modal', function () {
	    $(this).removeData('bs.modal');
	});

	if ($('.late-expenses').length > 0) {
		new MW.components.WidgetMovements({
			wrapper: $('.late-expenses'),
			type: 0,
			late: true
		});
	}

	if ($('.next-expenses').length > 0) {
		new MW.components.WidgetMovements({
			wrapper: $('.next-expenses'),
			type: 0,
			late: false
		});
	}
});
