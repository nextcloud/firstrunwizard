<?php
/**
 * @copyright 2012 Frank Karlitschek karlitschek@kde.org
 *
 * @author Georg Ehrke <georg@owncloud.com>
 * @author Lukas Reschke <lukas@statuscode.ch>
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
namespace OCA\FirstRunWizard;

use OCP\Util;

Util::addStyle('firstrunwizard', 'colorbox');
Util::addScript('firstrunwizard', 'jquery.colorbox');
Util::addScript('firstrunwizard', 'firstrunwizard');

Util::addStyle('firstrunwizard', 'firstrunwizard');

$config = \OC::$server->getConfig();
$userSession = \OC::$server->getUserSession();
$firstRunConfig = new Config($config, $userSession);

if ($userSession->isLoggedIn() && $firstRunConfig->isEnabled()) {
	Util::addScript( 'firstrunwizard', 'activate');
}
