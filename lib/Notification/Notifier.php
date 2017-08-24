<?php
/**
 * @copyright Copyright (c) 2016 Joas Schilling <coding@schilljs.com>
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

namespace OCA\FirstRunWizard\Notification;


use OCP\IURLGenerator;
use OCP\IUserManager;
use OCP\L10N\IFactory;
use OCP\Notification\IManager as INotificationManager;
use OCP\Notification\INotification;
use OCP\Notification\INotifier;

class Notifier implements INotifier {

	/** @var IFactory */
	protected $factory;

	/** @var IUserManager */
	protected $userManager;

	/** @var INotificationManager */
	protected $notificationManager;

	/** @var IURLGenerator */
	protected $url;

	/**
	 * @param IFactory $factory
	 * @param IUserManager $userManager
	 * @param INotificationManager $notificationManager
	 * @param IURLGenerator $urlGenerator
	 */
	public function __construct(IFactory $factory, IUserManager $userManager, INotificationManager $notificationManager, IURLGenerator $urlGenerator) {
		$this->factory = $factory;
		$this->userManager = $userManager;
		$this->notificationManager = $notificationManager;
		$this->url = $urlGenerator;
	}

	/**
	 * @param INotification $notification
	 * @param string $languageCode The code of the language that should be used to prepare the notification
	 * @return INotification
	 * @throws \InvalidArgumentException When the notification was not prepared by a notifier
	 * @since 9.0.0
	 */
	public function prepare(INotification $notification, $languageCode) {
		if ($notification->getApp() !== 'firstrunwizard') {
			// Not my app => throw
			throw new \InvalidArgumentException();
		}

		switch ($notification->getSubject()) {
			case 'profile':
				$subject = $this->getSubject($notification, $languageCode);
				if ($subject === '') {
					// Everything done, mark the notification as processed...
					$this->notificationManager->markProcessed($notification);
					throw new \InvalidArgumentException();
				}

				$notification->setParsedSubject($subject)
					->setLink($this->url->getAbsoluteURL('index.php/settings/user'));
				return $notification;

			default:
				// Unknown subject => Unknown notification => throw
				throw new \InvalidArgumentException();
		}
	}

	/**
	 * @param INotification $notification
	 * @param string $languageCode
	 * @return string
	 */
	protected function getSubject(INotification $notification, $languageCode) {
		$l = $this->factory->get('firstrunwizard', $languageCode);
		$user = $this->userManager->get($notification->getUser());

		$email = $user->getEMailAddress();
		if ($email === null || $email === '') {
			return $l->t('Add your profile information! For example your email is needed to reset your password.');
		}

		if ($user->canChangeDisplayName() && $user->getDisplayName() === $user->getUID()) {
			if ($user->canChangeAvatar() && $user->getAvatarImage(32) === null) {
				return $l->t('Add your profile information! Set a profile picture and full name for easier recognition across all features.');
			} else  {
				return $l->t('Add your profile information! Set a full name for easier recognition across all features.');
			}
		} else {
			if ($user->canChangeAvatar() && $user->getAvatarImage(32) === null) {
				return $l->t('Add your profile information! Set a profile picture for easier recognition across all features.');
			} else  {
				return '';
			}
		}
	}
}
