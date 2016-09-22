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

use OCA\FirstRunWizard\Notification\Notifier;
use OCP\AppFramework\App;
use OCP\IConfig;
use OCP\IL10N;
use OCP\IRequest;
use OCP\IUser;
use OCP\IUserSession;
use OCP\Util;
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
		$dispatcher = $this->getContainer()->query(EventDispatcherInterface::class);

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

			if ($config->getUserValue($user->getUID(), 'firstrunwizard', 'show', '1') !== '0') {
				style('firstrunwizard', ['colorbox', 'firstrunwizard']);
				script('firstrunwizard', ['jquery.colorbox', 'firstrunwizard', 'activate']);

				$jobList = $this->getContainer()->getServer()->getJobList();
				$jobList->add('OCA\FirstRunWizard\Notification\BackgroundJob', ['uid' => $userSession->getUser()->getUID()]);
			}
		});

		/** @var IRequest $request */
		$request = $this->getContainer()->query(IRequest::class);
		// Allow to enable the first run wizard with the button on the personal page
		if (strpos($request->getPathInfo(), '/settings/personal') === 0) {
			Util::addStyle('firstrunwizard', 'colorbox');
			Util::addStyle('firstrunwizard', 'firstrunwizard');
			Util::addScript('firstrunwizard', 'jquery.colorbox');
			Util::addScript('firstrunwizard', 'firstrunwizard');
		}
	}

	protected function registerNotificationNotifier() {
		$this->getContainer()->getServer()->getNotificationManager()->registerNotifier(function() {
			return $this->getContainer()->query(Notifier::class);
		}, function() {
			$l = $this->getContainer()->query(IL10N::class);
			return [
				'id' => 'firstrunwizard',
				'name' => $l->t('First run wizard'),
			];
		});
	}
}
