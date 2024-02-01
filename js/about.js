document.addEventListener('DOMContentLoaded', function() {
	const aboutEntry = document.querySelector('#firstrunwizard_about button');

	const addListener = () => {
		const aboutEntry = document.querySelector('#firstrunwizard_about button');

		aboutEntry.addEventListener('click', function (event) {
			event.stopPropagation();
			event.preventDefault();
			OCP.Loader.loadScript('firstrunwizard', 'firstrunwizard-main.js').then(function () {
				OCA.FirstRunWizard.open({
					setReturnFocus: document.querySelector('[aria-controls="header-menu-user-menu"]') ?? undefined,
				});
				OC.hideMenus(function () {
					return false;
				});
			});
			return true;
		});
	}

	if (aboutEntry) {
		addListener()
	} else {
		window._nc_event_bus.subscribe('core:user-menu:mounted', addListener)
	}
});
