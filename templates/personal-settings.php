<?php
/**
 * @copyright Copyright (c) 2017 Arthur Schiwon <blizzz@arthur-schiwon.de>
 *
 * @author Arthur Schiwon <blizzz@arthur-schiwon.de>
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
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/** @var \OCP\Defaults $theme */
/** @var array $_ */
style('firstrunwizard', ['personalsettings']);
script('firstrunwizard', ['personalsettings']);
?>
<div class="settings-mobile-desktop">
	<div id="clientsbox" class="section clientsbox">
		<h2><?php p($l->t('Get the apps to sync your files'));?></h2>

		<p class="settings-hint"><?php p($l->t('%s gives you access to your files wherever you are. Our easy to use desktop and mobile clients are available for all major platforms at zero cost.', [$theme->getName()])); ?></p>

		<div class="clientslinks">
			<a href="<?php p($_['clients']['desktop']); ?>" rel="noreferrer noopener" target="_blank">
				<img src="<?php print_unescaped(image_path('core', 'desktopapp.svg')); ?>"
					 alt="<?php p($l->t('Desktop client'));?>"/>
			</a>
			<a href="<?php p($_['clients']['android']); ?>" rel="noreferrer noopener" target="_blank">
				<img src="<?php print_unescaped(image_path('core', 'googleplay.png')); ?>"
					 alt="<?php p($l->t('Android app on Google Play Store'));?>" />
			</a>
			<a href="<?php p($_['clients']['fdroid']); ?>" rel="noreferrer noopener" target="_blank">
				<img src="<?php print_unescaped(image_path('core', 'f-droid.svg')); ?>"
					 alt="<?php p($l->t('Android app on F-Droid'));?>" />
			</a>
			<a href="<?php p($_['clients']['ios']); ?>" rel="noreferrer noopener" target="_blank">
				<img src="<?php print_unescaped(image_path('core', 'appstore.svg')); ?>"
					 alt="<?php p($l->t('iOS app'));?>" />
			</a>
		</div>
		<?php
		$appPasswordUrl = \OC::$server->getURLGenerator()->linkToRoute('settings.PersonalSettings.index', ['section' => 'security']);
$macOSProfile = \OCP\Util::linkToRemote('dav') . 'provisioning/apple-provisioning.mobileconfig';
$usesTLS = \OC::$server->getRequest()->getServerProtocol() === 'https';
?>
		<p><?php print_unescaped($l->t('Set up sync clients using an <a href="%s">app password</a>. That way you can make sure you are able to revoke access in case you lose that device.', [$appPasswordUrl])); ?></p>
	</div>
	<div class="section">
		<h2><?php p($l->t('Connect other apps to %s', [$theme->getName()])); ?></h2>

		<p class="settings-hint"><?php print_unescaped($l->t('Besides the mobile apps and desktop client you can connect any other software that supports the WebDAV/CalDAV/CardDAV protocols to %s.', [$theme->getName()])); ?></p>

		<div class="clientslinks">
			<a target="_blank" class="button" href="<?php p(link_to_docs('user-sync-calendars')) ?>" rel="noreferrer noopener">
				<img class="appsmall appsmall-calendar svg" alt=""
					 src="<?php p(image_path('core', 'places/calendar.svg')); ?>" />
				<?php p($l->t('Connect your calendar'));?>
			</a>
			<a target="_blank" class="button" href="<?php p(link_to_docs('user-sync-contacts')) ?>" rel="noreferrer noopener">
				<img class="appsmall appsmall-contacts svg" alt=""
					 src="<?php p(image_path('core', 'places/contacts.svg')); ?>" />
				<?php p($l->t('Connect your contacts'));?>
			</a>
			<a target="_blank" class="button" href="<?php p(link_to_docs('user-webdav')); ?>" rel="noreferrer noopener">
				<img class="appsmall svg" alt=""
					 src="<?php p(image_path('files', 'folder.svg')); ?>" />
				<?php p($l->t('Access files via WebDAV'));?>
			</a>
			<?php if ($usesTLS): ?>
				<a target="_blank" class="button" href="<?php p($macOSProfile); ?>" rel="noreferrer noopener">
					<img class="appsmall appsmall-contacts svg" alt=""
						 src="<?php p(image_path('core', 'places/default-app-icon.svg')); ?>" />
					<?php p($l->t('Download macOS/iOS configuration profile'));?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<div class="section">
		<h2><?php p($l->t('Server address')); ?></h2>

		<p class="settings-hint"><?php p($l->t('Use this link to connect your apps and desktop client to this server:')); ?></p>

		<input type="text" readonly="readonly" id="endpoint-url" value="<?php echo p($_['url']); ?>" />
		<button class="button" data-clipboard-target="#endpoint-url">
			<img class="appsmall svg" alt=""
				 src="<?php p(image_path('core', 'actions/clippy.svg')); ?>" />
			<?php p($l->t('Copy link')); ?></button>
	</div>
</div>

