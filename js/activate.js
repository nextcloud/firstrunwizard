document.addEventListener('DOMContentLoaded', function() {
	window.OCP.Loader.loadScript('firstrunwizard', 'firstrunwizard.js').then(function() {
		OCA.FirstRunWizard.open();
	});
});
