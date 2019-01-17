document.addEventListener('DOMContentLoaded', function() {
	document.querySelector('#expanddiv li[data-id="firstrunwizard-about"] a').addEventListener('click', function (event) {
		event.stopPropagation();
		event.preventDefault();
		OCP.Loader.loadScript('firstrunwizard', 'firstrunwizard.js').then(function() {
			OCA.FirstRunWizard.open();
			OC.hideMenus(function () {
				return false;
			});
		});
		return true;
	});
});
