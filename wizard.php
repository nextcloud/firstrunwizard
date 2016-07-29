<?php
/**
* @copyright 2012 Frank Karlitschek frank@owncloud.org
 *
 * @author Bernhard Posselt <dev@bernhard-posselt.com>
 * @author Bjoern Schiessle <bjoern@schiessle.org>
 * @author Björn Schießle <bjoern@schiessle.org>
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

use OCP\Defaults;
use OCP\User;
use OCP\Util as CoreUtil;
use OCP\Template;

// Check if we are a user
User::checkLoggedIn();

$appManager = \OC::$server->getAppManager();
$config = \OC::$server->getConfig();
$defaults = new Defaults();

$util = new Util($appManager, $config, $defaults);

$tmpl = new Template('firstrunwizard', 'wizard', '');
$tmpl->assign('logo', CoreUtil::linkTo('core','img/logo-inverted.svg'));
$tmpl->assign('clients', $util->getSyncClientUrls());
$tmpl->assign('edition', $util->getEdition());
$tmpl->assign('slogan', $util->getSlogan());
$tmpl->assign('url', $util->getUrl());
$tmpl->assign('documentation', $util->getDocumentationUrl());
$tmpl->printPage();
