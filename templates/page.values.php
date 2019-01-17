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

<div class="page" data-title="<?php p($l->t('A safe home for all your data')); ?>" data-subtitle="">
	<div class="content content-values">
		<p>
			<?php p($l->t('Nextcloud puts your data at your fingertips, under your control. Store your documents, calendar, contacts and photos on a server in your company, at home, at one of our providers or in a data center you know.')); ?>
		</p>

		<ul id="wizard-values">
			<li>
				<span class="icon-link"></span>
				<h3><?php p($l->t('Host your data and files where you decide')); ?></h3>
			</li>
			<li>
				<span class="icon-shared"></span>
				<h3><?php p($l->t('Open Standards and Interoperability')); ?></h3>
			</li>
			<li>
				<span class="icon-user"></span>
				<h3><?php p($l->t('100%% Open Source & community-focused')); ?></h3>
			</li>
		</ul>

		<p class="details-link"><a href="<?php p($theme->getBaseUrl()); ?>" target="_blank" rel="noreferrer noopener"><?php p($l->t('Learn more about %s', $theme->getName())); ?></a></p>
	</div>
</div>
