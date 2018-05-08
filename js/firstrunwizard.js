(function() {
	if (!OCA.FirstRunWizard) {
		OCA.FirstRunWizard = {};
	}
	OCA.FirstRunWizard.Wizard = {

		initialize: function () {

		},
		getTotal: function() {
			return this.$pages.length;
		},
		getCurrent: function () {
			return $('#firstrunwizard .page.active').index('#firstrunwizard .page');
		},
		isLast: function() {
			return this.getCurrent() >= this.getTotal()-1;
		},
		isFirst: function() {
			return this.getCurrent() === 0;
		},
		updateTitle: function() {
			var active = $('#firstrunwizard .page.active');
			var header = this.$wizard.find('.firstrunwizard-header');
			header.find('h1').text(active.data('title'));
			header.find('p').text(active.data('subtitle'));
		},
		goNext: function() {
			if (this.isLast()) {
				return;
			}
			var active = $('#firstrunwizard .page.active');
			var next = active.next();
			this.$prev.show();
			if (this.getCurrent() < this.getTotal()-1) {
				active.hide().removeClass('active');
				next.show().addClass('active');
			}

			this.$position.find('li').removeClass('active');
			this.$position.find('>li:nth-child(' + (this.getCurrent()+1) + ')').addClass('active');

			if (this.isLast()) {
				this.$next.hide();
				this.$finish.show();
			} else {
				this.$next.show();
				this.$finish.hide();
			}
			this.updateTitle();
			$.colorbox.resize();
		},
		goPrevious: function() {
			if (this.isFirst()) {
				return;
			}
			var active = $('#firstrunwizard .page.active');
			var prev = active.prev();
			active.hide().removeClass('active');
			prev.show().addClass('active');
			this.$next.show();
			this.$finish.hide();
			if (!this.isFirst()) {
				active.hide().removeClass('active');
				prev.show().addClass('active');
			}

			this.$position.find('li').removeClass('active');
			this.$position.find('>li:nth-child(' + (this.getCurrent()+1) + ')').addClass('active');

			if (this.isFirst()) {
				this.$prev.hide();
			} else {
				this.$prev.show();
			}
			this.updateTitle();
			$.colorbox.resize();
		},
		handleKeydown: function(e) {
			switch (e.keyCode) {
				case 37: // arrow left
					this.goPrevious();
					break;
				case 13:
				case 39:
					this.goNext();
					break;
				case 27:
					this.closeWizard();
					break;
			}
		},
		onComplete: function() {
			this.$wizard = $('#firstrunwizard');
			this.$finish = this.$wizard.find('#finish');
			this.$prev = this.$wizard.find('#prev');
			this.$next = this.$wizard.find('#next');
			this.$pages = this.$wizard.find('.page');
			this.$position = this.$wizard.find('.position-indicator');

			this.$finish.hide();
			this.$pages.hide();
			this.$prev.hide();
			this.$pages.first().fadeIn().addClass('active');
			$.colorbox.resize();
			var self = this;
			this.$pages.each(function() {
				self.$position.append('<li></li>');
			});
			this.$position.find('>li:first-child').addClass('active');

			this.$wizard.on('click', '#next', this.goNext.bind(this));
			this.$wizard.on('click', '#prev', this.goPrevious.bind(this));
			this.$wizard.on('click', '#finish', this.closeWizard.bind(this));
			this.$wizard.on('click', '#closeWizard', this.closeWizard.bind(this));
			$('body').off('keydown', this.handleKeydown).on('keydown', this.handleKeydown.bind(this));
			this.updateTitle();
		},
		closeWizard: function() {
			$('body').off('keydown', this.handleKeydown);
			$.colorbox.close();
		},

		showFirstRunWizard: function(){
			var self = this;
			$.colorbox({
				opacity: 0.7,
				transition: 'elastic',
				speed: 100,
				width: '80%',
				height: '80%',
				maxWidth: '900px',
				href: OC.generateUrl('/apps/firstrunwizard/wizard'),
				onClosed : function() {
					$.ajax({
						url: OC.generateUrl('/apps/firstrunwizard/wizard'),
						type: 'delete'
					});
				},
				onComplete: self.onComplete.bind(self),
			});
		}
	};
})();

$(document).ready(function() {
	$('#showWizard').on('click', function () {
		OCA.FirstRunWizard.Wizard.showFirstRunWizard();
	});

	$('#expanddiv li[data-id="firstrunwizard-about"] a').on('click', function () {
		OCA.FirstRunWizard.Wizard.showFirstRunWizard();
		$(this).find('div').remove();
		$(this).find('img').show();
		OC.hideMenus(function(){return false;});
		return false;
	});
});
