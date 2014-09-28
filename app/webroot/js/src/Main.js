$(document).ready(function() {
	MW.i.delegator = new MW.services.Delegator();

	$('body').on('hidden.bs.modal', '.modal', function () {
	    $(this).removeData('bs.modal');
	});
});