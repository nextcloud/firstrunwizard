<?php

/**
* ownCloud - First Run Wizard
*
* @author Frank Karlitschek
* @copyright 2012 Frank Karlitschek frank@owncloud.org
*
* This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU AFFERO GENERAL PUBLIC LICENSE
* License as published by the Free Software Foundation; either
* version 3 of the License, or any later version.
*
* This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU AFFERO GENERAL PUBLIC LICENSE for more details.
*
* You should have received a copy of the GNU Affero General Public
* License along with this library.  If not, see <http://www.gnu.org/licenses/>.
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
$tmpl->printPage();
