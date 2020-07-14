<?php
/**
 * @copyright Copyright (c) 2016, Joas Schilling <coding@schilljs.com>
 *
 * @author Joas Schilling <coding@schilljs.com>
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

namespace OCA\FirstRunWizard\AppInfo;

use OCA\Files\Event\LoadAdditionalScriptsEvent;
use OCA\FirstRunWizard\Listener\LoadAdditionalScriptsListener;
use OCA\FirstRunWizard\Listener\LoadAdditionalScriptsLoggedInListener;
use OCA\FirstRunWizard\Notification\AppHint;
use OCA\FirstRunWizard\Notification\Notifier;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Http\Events\LoadAdditionalScriptsLoggedInEvent;

class Application extends App implements IBootstrap {

	/** @var bool */
	protected $isCLI;

	public function __construct() {
		parent::__construct('firstrunwizard');
		$this->isCLI = \OC::$CLI;
	}

	public function register(IRegistrationContext $context): void {
		// Display the first run wizard only on the files app
		$context->registerEventListener(LoadAdditionalScriptsEvent::class, LoadAdditionalScriptsListener::class);
		$context->registerEventListener(LoadAdditionalScriptsLoggedInEvent::class, LoadAdditionalScriptsLoggedInListener::class);
	}

	public function boot(IBootContext $context): void {
		if (!$this->isCLI) {
			$serverContainer = $context->getServerContainer();
			$serverContainer->getNotificationManager()->registerNotifierService(Notifier::class);

			$appContainer = $context->getAppContainer();
			/** @var AppHint $appHint */
			$appHint = $appContainer->query(AppHint::class);
			$appHint->registerAppListener();
		}
	}
}
