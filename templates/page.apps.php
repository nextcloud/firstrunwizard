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
<div class="page" data-title="<?php p($l->t('Extend your cloud')); ?>" data-subtitle="">
	<div class="image"><img src="<?php p(image_path('firstrunwizard', 'appstore.svg')); ?>" /></div>
	<div class="description">
		<p><?php p($l->t('Find more than 100 apps in the Nextcloud app store to customize your cloud:')); ?></p>
		<ul>
			<li><?php p($l->t('Groupware apps like Calendar, Contacts, Mail')); ?></li>
			<li><?php p($l->t('Communication with Nextcloud Talk')); ?></li>
			<li><?php p($l->t('Collaboration apps for document editing')); ?></li>
			<li><?php p($l->t('Security and authentication features like two-factor authentication, SSO and ransomware protection')); ?></li>
			<li><?php p($l->t('Many others like a music player, a password manager, a kanban app, a download manager or a markdown editor')); ?></li>

		</ul>
		<p class="details-link">
			<a href="<?php p(\OC::$server->getURLGenerator()->linkToRoute('settings.AppSettings.viewApps')); ?>" target="_blank" rel="noreferrer noopener">
				<?php p($l->t('Browse the app store')); ?>
			</a>
		</p>
	</div>
</div>
