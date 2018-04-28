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
<div class="page" data-title="Extend your cloud" data-subtitle="">
	<div class="image"><img src="<?php p(image_path('firstrunwizard', 'appstore.svg')); ?>" /></div>
	<div class="description">
		<p><?php p($l->t('You can extend the functionality of your %s with extra features from the Nextcloud app store. Among the more than 100 apps you can find features that enhance sharing, including:', $theme->getName())); ?></p>
		<ul>
			<li><?php p($l->t('Groupware apps like Calendar, Contacts, Mail, News, Notes, Bookmarks and Tasks')); ?></li>
			<li><?php p($l->t('Collaboration and productivity apps Keepass management, Video Calls, a Kanban app, music players, Password managers, Checksums, download manager, a Markdown editor and collaborative text editing.')); ?></li>
			<li><?php p($l->t('Security and authentication features like two-factor authentication mechanisms, SSO, Ransomware protection, admin announcements, Zimbra integration, a tiny CMS app and more.')); ?></li>
		</ul>
		<p class="details-link"><a href="/index.php/settings/apps" target="_blank"><?php p($l->t('Browse the app store')); ?></a></p>
	</div>
</div>
