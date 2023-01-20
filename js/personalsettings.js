(function($, OC, _) {
	$(document).ready(function() {
		initLinkToClipboard()
		$('#endpoint-url').on('click', function() {
			$(this).select()
		})
	})

	function initLinkToClipboard() {
		// Clipboard!
		var clipboard = new Clipboard('.clipboardButton')
		clipboard.on('success', function(e) {
			OC.Notification.show(t('firstrunwizard', 'Copied!'), { type: 'success' })
		})

		clipboard.on('error', function(e) {
			var actionMsg = ''
			if (/iPhone|iPad/i.test(navigator.userAgent)) {
				actionMsg = t('firstrunwizard', 'Not supported!')
			} else if (/Mac/i.test(navigator.userAgent)) {
				actionMsg = t('firstrunwizard', 'Press ⌘-C to copy.')
			} else {
				actionMsg = t('firstrunwizard', 'Press Ctrl-C to copy.')
			}
			// show error
			OC.Notification.show(actionMsg, { type: 'error' })
		})
	}
})(jQuery, OC, _)
