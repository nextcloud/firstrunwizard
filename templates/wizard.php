<?php
/**
 * @var array $_
 * @var \OCP\IL10N $l
 * @var \OCP\Defaults $theme
 */
?>
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

		<h2><?php print_unescaped(htmlspecialchars($theme->getSlogan(), ENT_QUOTES, 'UTF-8', false)); ?></h2>
		<p></p>

	</div>

	<div class="firstrunwizard-content">
		<?php
		print_unescaped($this->inc('page.intro'));
		print_unescaped($this->inc('page.values'));
		print_unescaped($this->inc('page.clients'));

		$uid = \OC::$server->getUserSession()->getUser()->getUID();
		if ($_['appStore'] && OC_User::isAdminUser($uid)) {
			print_unescaped($this->inc('page.apps'));
		}
		print_unescaped($this->inc('page.final'));
		?>

		<div class="wizard-navigation">
			<div class="prev">
				<button id="prev"><?php p($l->t('Previous')); ?></button>
			</div>
			<div><ul class="position-indicator"></ul></div>
			<div class="next">
				<button class="primary" id="next"><?php p($l->t('Next')); ?></button>
				<button class="primary" id="finish"><?php p($l->t('Start using Nextcloud')); ?></button>
			</div>
		</div>
	</div>
</div>
