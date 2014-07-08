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


// Check if we are a user
OCP\User::checkLoggedIn();

$defaults = new \OCP\Defaults();

//links to clients
//these methods are in core #9520
if (method_exists($defaults, 'getAndroidClientUrl')) {
	$androidurl = $defaults->getAndroidClientURL();
} else {
	$androidurl = 'https://play.google.com/store/apps/details?id=com.owncloud.android';
}
if (method_exists($defaults, 'getiOSClientUrl')) {
	$iosurl = $defaults->getiOSClientUrl();
} else {
	$iosurl = 'https://itunes.apple.com/us/app/owncloud/id543672169?mt=8';
}
$clients = array(
	'desktop' => OCP\Config::getSystemValue('customclient_desktop', $defaults->getSyncClientUrl()),
	'android' => OCP\Config::getSystemValue('customclient_android', $androidurl),
	'ios'     => OCP\Config::getSystemValue('customclient_ios', $iosurl)
);

$tmpl = new OCP\Template( 'firstrunwizard', 'wizard', '' );
$tmpl->assign('logo', OCP\Util::linkTo('core','img/logo-inverted.svg'));
$tmpl->assign('clients', $clients);
$tmpl->printPage();

