<?php
/**
 * @var array $_
 * @var \OCP\IL10N $l
 * @var \OCP\Defaults $theme
 */
?>
<div id="firstrunwizard-outer-navigation">
	<a id="prev" class="icon-view-previous icon-white"><span class="hidden-visually"><?php p($l->t('Previous')); ?></span></a>
	<a id="next" class="icon-view-next icon-white"><span class="hidden-visually"><?php p($l->t('Next')); ?></span></a>
</div>
<div id="firstrunwizard">
	<div class="firstrunwizard-header">

		<a id="closeWizard" class="close">
			<img class="svg"
				 src="<?php p(image_path('core', 'actions/view-close.svg')); ?>">
		</a>
		<div class="logo">
			<p class="hidden-visually">
				<?php p($theme->getName()); ?>
			</p>
		</div>

		<h2><?php p($theme->getSlogan()); ?></h2>
		<p></p>

	</div>

	<div class="firstrunwizard-content">
		<?php
		print_unescaped($this->inc('page.intro'));
		print_unescaped($this->inc('page.values'));
		print_unescaped($this->inc('page.clients'));

		$uid = \OC::$server->getUserSession()->getUser()->getUID();
		if (OC_User::isAdminUser($uid)) {
			print_unescaped($this->inc('page.apps'));
		}
		print_unescaped($this->inc('page.final'));
		?>

		<div class="wizard-navigation">
			<div class="prev">
			</div>
			<div><ul class="position-indicator"></ul></div>
			<div class="next">
				<button class="primary" id="finish"><?php p($l->t('Start using Nextcloud')); ?></button>
			</div>
		</div>
	</div>
</div>
