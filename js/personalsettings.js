(function($, OC, _) {
	$(document).ready(function() {
		initLinkToClipboard()
		$('#endpoint-url').on('click', function() {
			$(this).select()
		})
	})

	function initLinkToClipboard() {
		var originalTitle = t('firstrunwizard', 'Copy to clipboard')

		/* reused from settings/js/authtoken_view.js */
		$('#endpoint-url + .clipboardButton').tooltip({
			placement: 'bottom',
			title: originalTitle,
			trigger: 'hover'
		})

		// Clipboard!
		var clipboard = new Clipboard('.clipboardButton')
		clipboard.on('success', function(e) {
			var $input = $(e.trigger)

			// show copied notification
			$input.tooltip('hide')
				.attr('data-original-title', t('firstrunwizard', 'Copied!'))
				.tooltip('fixTitle')
				.tooltip({
					placement: 'bottom',
					trigger: 'manual'
				})
				.tooltip('show')

			// revert back to original title
			_.delay(function() {
				$input.tooltip('hide')
					.attr('data-original-title', originalTitle)
					.tooltip('fixTitle')
			}, 3000)
		})

		clipboard.on('error', function(e) {
			var $input = $(e.trigger)
			var actionMsg = ''
			if (/iPhone|iPad/i.test(navigator.userAgent)) {
				actionMsg = t('firstrunwizard', 'Not supported!')
			} else if (/Mac/i.test(navigator.userAgent)) {
				actionMsg = t('firstrunwizard', 'Press ⌘-C to copy.')
			} else {
				actionMsg = t('firstrunwizard', 'Press Ctrl-C to copy.')
			}

			// show error
			$input.tooltip('hide')
				.attr('data-original-title', actionMsg)
				.tooltip('fixTitle')
				.tooltip({
					placement: 'bottom',
					trigger: 'manual'
				})
				.tooltip('show')

			// revert back to original title
			_.delay(function() {
				$input.tooltip('hide')
					.attr('data-original-title', originalTitle)
					.tooltip('fixTitle')
			}, 3000)
		})
	}
})(jQuery, OC, _)