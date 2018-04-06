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

		<h1><?php p($theme->getSlogan()); ?></h1>
		<p><?php p($l->t('Access & share your files, calendars, contacts, mail & more from any device, on your terms')); ?></p>

	</div>

	<div class="firstrunwizard-content">
		<div class="page" data-title="a safe home for all your data" data-subtitle="Access & share your files, calendars, contacts, mail & more from any device, on your terms">
			<div class="image"><img src="<?php p(image_path('firstrunwizard', 'cube.svg')); ?>" /></div>
			<div class="description">
				<p>Nextcloud puts your data at your fingertips, under your control. Store your documents, calendar, contacts and photos on a server at home, at one of our providers or in a data center you know.</p>
				<p>We have some tipps for you to get started:</p>
				<ul>
					<li><a href="#">Easy access anywhere - Setup sync clients</a></li>
					<li><a href="#">Extend your cloud - Explore the Nextcloud app store</a></li>
					<li><a href="#">Groupware - Calendar, Contacts, Mail</a></li>
					<li><a href="#">Stay in touch - Audio & video calls with Talk</a></li>
					<li><a href="#">Get help - Manual and support</a></li>
				</ul>
			</div>
		</div>

		<div class="page" data-title="Extend your cloud" data-subtitle="" data-image="<?php p(image_path('firstrunwizard', 'appstore.svg')); ?>">
			<div class="image"><img src="<?php p(image_path('firstrunwizard', 'appstore.svg')); ?>" /></div>
			<div class="description">
				<p>
					You can extend the functionality of your Nextcloud with extra features from the Nextcloud app store. Among the more than 100 apps you can find features that enhance sharing, including:
				</p>
				<ul>
					<li>Groupware apps like Calendar, Contacts, Mail, News, Notes, Bookmarks and Tasks</li>
					<li>Collaboration and productivity apps Keepass management, Video Calls, a Kanban app, music players, Password managers, Checksums, download manager, a Markdown editor and collaborative text editing.</li>
					<li>Security and authentication features like two-factor authentication mechanisms, SSO, Ransomware protection, admin announcements, Zimbra integration, a tiny CMS app and more.</li>
				</ul>

				<a class="button primary" href="/index.php/settings/apps">Browse the app store</a>
			</div>
		</div>

		<div class="page">
			<div class="content">
			<p>Nextcloud gives you access to your files wherever you are. Our easy to use desktop and mobile clients are available for all major platforms at zero cost!</p>
			<h2><?php p($l->t('Get the apps to sync your files')); ?></h2>
			<a target="_blank" href="<?php p($_['desktop']); ?>">
				<img src="<?php p(image_path('core', 'desktopapp.svg')); ?>"
					 alt="<?php p($l->t('Desktop client')); ?>"/>
			</a>
			<a target="_blank" href="<?php p($_['android']); ?>">
				<img src="<?php p(image_path('core', 'googleplay.svg')); ?>"
					 alt="<?php p($l->t('Android app')); ?>"
					 style="height:60px"/>
			</a>
			<a target="_blank" href="<?php p($_['ios']); ?>">
				<img src="<?php p(image_path('core', 'appstore.svg')); ?>"
					 alt="<?php p($l->t('iOS app')); ?>" style="height:60px"/>
			</a>
			<h2><?php p($l->t('Connect your desktop apps to %s', array($theme->getName()))); ?></h2>
			<a target="_blank" class="button"
			   href="<?php p(link_to_docs('user-sync-calendars')) ?>">
				<img class="appsmall appsmall-calendar svg" alt=""
					 src="<?php p(image_path('core', 'places/calendar-dark.svg')); ?>"/>
				<?php p($l->t('Connect your calendar')); ?>
			</a>
			<a target="_blank" class="button"
			   href="<?php p(link_to_docs('user-sync-contacts')) ?>">
				<img class="appsmall appsmall-contacts svg" alt=""
					 src="<?php p(image_path('core', 'places/contacts-dark.svg')); ?>"/>
				<?php p($l->t('Connect your contacts')); ?>
			</a>
			<a target="_blank" class="button"
			   href="<?php p(link_to_docs('user-webdav')); ?>">
				<img class="appsmall svg" alt=""
					 src="<?php p(image_path('files', 'folder.svg')); ?>"/>
				<?php p($l->t('Access files via WebDAV')); ?>
			</a>
		</div>
		</div>
		<div class="page">
			<div class="description">
				<h2><?php p($l->t('Get more information')); ?></h2>
				<p>The Nextcloud documentation for home users:</p>
				<ul>
					<li><a href="#">Admin manual</a></li>
					<li><a href="#">User manual</a></li>
					<li><a href="#">Developer manual</a></li>
				</ul>
				<p>You can also ask for help in our community support channels:</p>
				<ul>
					<li><a href="https://help.nextcloud.com">the Nextcloud forums</a></li>
					<li><a href="">the Nextcloud IRC chat channel on freenode.net, also accessible via webchat</a></li>
				</ul>
			</div>
			<div class="description">

				<h2>Start contributing</h2>
				<p>Do you want to get a certain improvement in Nextcloud? Did you find a problem? Do you want to help translate, promote or document Nextcloud?</p>
				<a href="https://nextcloud.com/contribute/" class="button">Become part of the Community.</a>

				<h2>Enterprise support</h2>
				<p>If you run Nextcloud in a mission critical environment with large numbers of users and big amounts of data and need the certainty of support from the experts behind the Nextcloud technology, a Enterprise Subscription from Nextcloud is available with email and phone support.</p>
				<a href="https://nextcloud.com/enterprise/buy" class="button">Get enterprise support</a>

			</div>
		</div>

		<div class="wizard-navigation">
			<div class="prev">
				<button id="prev"><?php p($l->t('Previous')); ?></button>
			</div>
			<div class="next">
				<button class="primary" id="next"><?php p($l->t('Next')); ?></button>
				<button class="primary" id="finish"><?php p($l->t('Start using Nextcloud')); ?></button>
			</div>
		</div>
	</div>
</div>