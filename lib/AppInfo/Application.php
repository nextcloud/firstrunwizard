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

use OCA\FirstRunWizard\Notification\AppHint;
use OCA\FirstRunWizard\Notification\Notifier;
use OCP\AppFramework\App;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IUser;
use OCP\IUserSession;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Application extends App {

	/** @var bool */
	protected $isCLI;

	public function __construct() {
		parent::__construct('firstrunwizard');
		$this->isCLI = \OC::$CLI;
	}

	public function register() {
		if (!$this->isCLI) {
			$this->registerScripts();
			$this->registerNotificationNotifier();
		}
	}

	protected function registerScripts() {
		/** @var EventDispatcherInterface $dispatcher */
		$dispatcher = $this->getContainer()->getServer()->getEventDispatcher();

		$dispatcher->addListener(TemplateResponse::EVENT_LOAD_ADDITIONAL_SCRIPTS_LOGGEDIN, function() {
			\OC_Util::addScript('firstrunwizard', 'about');
		});

		// Display the first run wizard only on the files app,
		$dispatcher->addListener('OCA\Files::loadAdditionalScripts', function() {
			/** @var IUserSession $userSession */
			$userSession = $this->getContainer()->query(IUserSession::class);
			$user = $userSession->getUser();

			if (!$user instanceof IUser) {
				return;
			}

			/** @var IConfig $config */
			$config = $this->getContainer()->query(IConfig::class);
			$appHint = $this->getContainer()->query(AppHint::class);

			if ($config->getUserValue($user->getUID(), 'firstrunwizard', 'show', '1') !== '0') {
				\OC_Util::addScript('firstrunwizard', 'activate');

				$jobList = $this->getContainer()->getServer()->getJobList();
				$jobList->add('OCA\FirstRunWizard\Notification\BackgroundJob', ['uid' => $userSession->getUser()->getUID()]);
			}
			$appHint->sendAppHintNotifications();
		});
	}

	protected function registerNotificationNotifier() {
		$this->getContainer()->getServer()->getNotificationManager()->registerNotifierService(Notifier::class);

		/** @var AppHint $appHint */
		$appHint = $this->getContainer()->query(AppHint::class);
		$appHint->registerAppListener();
	}
}
