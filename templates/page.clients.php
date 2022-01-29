<?php
/**
 * @copyright Copyright (c) 2018 Julius Härtl <jus@bitgrid.net>
 *
 * @author Julius Härtl <jus@bitgrid.net>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * @var array $_
 * @var \OCP\IL10N $l
 * @var \OCP\Defaults $theme
 */
?>

<div class="page" data-title="<?php p($l->t('Stay in sync')); ?>" data-subtitle="">
	<div class="content content-clients">
		<p><?php p($l->t('Nextcloud gives you access to your files wherever you are.')); ?><br />
			<?php p($l->t('Our easy to use desktop and mobile clients are available for all major platforms at zero cost!')); ?></p>
		<div class="description-block">
			<h3><?php p($l->t('Get the apps to sync your files')); ?></h3>
			<a target="_blank" href="<?php p($_['desktop']); ?>" rel="noreferrer noopener">
				<img src="<?php p(image_path('core', 'desktopapp.svg')); ?>"
					 alt="<?php p($l->t('Desktop client')); ?>"/>
			</a>
			<a target="_blank" href="<?php p($_['android']); ?>" rel="noreferrer noopener">
				<img src="<?php p(image_path('core', 'googleplay.svg')); ?>"
					 alt="<?php p($l->t('Android app on Google Play Store')); ?>"
					 style="height:60px"/>
			</a>
			<a target="_blank" href="<?php p($_['fdroid']); ?>" rel="noreferrer noopener">
				<img src="<?php p(image_path('core', 'f-droid.svg')); ?>"
					 alt="<?php p($l->t('Android app on F-Droid')); ?>"
					 style="height:60px"/>
			</a>
			<a target="_blank" href="<?php p($_['ios']); ?>" rel="noreferrer noopener">
				<img src="<?php p(image_path('core', 'appstore.svg')); ?>"
					 alt="<?php p($l->t('iOS app')); ?>" style="height:60px"/>
			</a>
		</div>
		<div class="description-block">
			<h3><?php p($l->t('Connect your desktop apps to %s', array($theme->getName()))); ?></h3>
			<a target="_blank" class="button"
			   href="<?php p(link_to_docs('user-sync-calendars')) ?>" rel="noreferrer noopener">
				<span class="icon icon-calendar-dark"></span>
				<?php p($l->t('Connect your calendar')); ?>
			</a>
			<a target="_blank" class="button"
			   href="<?php p(link_to_docs('user-sync-contacts')) ?>" rel="noreferrer noopener">
				<span class="icon icon-contacts-dark"></span>
				<?php p($l->t('Connect your contacts')); ?>
			</a>
			<a target="_blank" class="button"
			   href="<?php p(link_to_docs('user-webdav')); ?>" rel="noreferrer noopener">
				<span class="icon icon-files-dark"></span>
				<?php p($l->t('Access files via WebDAV')); ?>
			</a>
			<?php if ($_['useTLS']): ?>
			<a target="_blank" class="button"
			   href="<?php p($_['macOSProfile']); ?>" rel="noreferrer noopener">
				<span class="icon icon-download"></span>
				<?php p($l->t('Download macOS/iOS configuration profile')); ?>
			</a>
			<?php endif; ?>
		</div>
	</div>
</div>
