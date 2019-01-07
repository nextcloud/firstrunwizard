$(document).ready(function() {
	OCP.Loader.loadScript('firstrunwizard', 'jquery.colorbox.js').then(function() {
		OCA.FirstRunWizard.Wizard.showFirstRunWizard();
	});
});
