document.addEventListener('DOMContentLoaded', function() {
	window.OCP.Loader.loadScript(appName, 'firstrunwizard-main.js').then(function() {
		OCA.FirstRunWizard.open(true);
	});
});
