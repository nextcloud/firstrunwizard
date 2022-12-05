document.addEventListener('DOMContentLoaded', function() {
	window.OCP.Loader.loadScript('firstrunwizard', 'firstrunwizard-main.js').then(function() {
		OCA.FirstRunWizard.open(true);
	});
});
