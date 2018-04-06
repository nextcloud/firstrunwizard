function getTotal() {
	return $('#firstrunwizard .page').length;
}

function getCurrent() {
	return $('#firstrunwizard .page.active').index('#firstrunwizard .page');
}

function isLast() {
	return getCurrent() >= getTotal()-1;
}

function isFirst() {
	return getCurrent() === 0;
}

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
		},
		onComplete: function() {
			var $wizard = $('#firstrunwizard');
			var $finish = $wizard.find('#finish');
			var $prev = $wizard.find('#prev');
			var $next = $wizard.find('#next');
			var $pages = $wizard.find('.page');
			$finish.hide();
			$pages.hide();
			$prev.hide();
			$pages.first().fadeIn().addClass('active');
			$.colorbox.resize();
			$wizard.on('click', '#next', function() {
				var active = $('#firstrunwizard .active');
				var next = active.next();
				$prev.show();
				if (getCurrent() < getTotal()-1) {
					active.hide().removeClass('active');
					next.show().addClass('active');
				}

				if (isLast()) {
					$next.hide();
					$finish.show();
				} else {
					$next.show();
					$finish.hide();
				}
				$.colorbox.resize();
			});
			$('#firstrunwizard').on('click', '#prev', function() {
				var active = $('#firstrunwizard .active');
				var prev = active.prev();
				active.hide().removeClass('active');
				prev.show().addClass('active');
				$next.show();
				$finish.hide();
				if (!isFirst()) {
					active.hide().removeClass('active');
					prev.show().addClass('active');
				}

				if (isFirst()) {
					$prev.hide();
				} else {
					$prev.show();
				}
				$.colorbox.resize();
			});
			$('#firstrunwizard').on('click', '#finish', function() {
				$.colorbox.close();
			});
		},
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
