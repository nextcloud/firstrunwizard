function showFirstRunWizard(){
	$.colorbox({
		opacity: 0.7,
		transition: 'elastic',
		speed: 100,
		width: '80%',
		height: '80%',
		href: OC.generateUrl('/apps/firstrunwizard/wizard'),
		onClosed : function() {
			$.ajax({
				url: OC.generateUrl('/apps/firstrunwizard/wizard'),
				type: 'delete'
			});
		}
	});
}

$(document).ready(function() {
	$('#showWizard').live('click', function () {
		showFirstRunWizard();
	});

	$('#closeWizard').live('click', function () {
		$.colorbox.close();
	});
});
