<?php
/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Tests\Notification;

use InvalidArgumentException;
use OCA\FirstRunWizard\Notification\Notifier;
use OCP\IConfig;
use OCP\IImage;
use OCP\IL10N;
use OCP\IURLGenerator;
use OCP\IUser;
use OCP\IUserManager;
use OCP\L10N\IFactory;
use OCP\Notification\IManager;
use OCP\Notification\INotification;
use Test\TestCase;

class NotifierTest extends TestCase {
	/** @var Notifier */
	protected $notifier;

	/** @var IConfig|\PHPUnit_Framework_MockObject_MockObject */
	protected $config;
	/** @var IManager|\PHPUnit_Framework_MockObject_MockObject */
	protected $manager;
	/** @var IUserManager|\PHPUnit_Framework_MockObject_MockObject */
	protected $userManager;
	/** @var IFactory|\PHPUnit_Framework_MockObject_MockObject */
	protected $factory;
	/** @var IURLGenerator|\PHPUnit_Framework_MockObject_MockObject */
	protected $urlGenerator;
	/** @var IL10N|\PHPUnit_Framework_MockObject_MockObject */
	protected $l;

	protected function setUp(): void {
		parent::setUp();

		$this->manager = $this->createMock(IManager::class);
		$this->userManager = $this->createMock(IUserManager::class);
		$this->urlGenerator = $this->createMock(IURLGenerator::class);
		$this->config = $this->createMock(IConfig::class);
		$this->l = $this->createMock(IL10N::class);
		$this->l->expects($this->any())
			->method('t')
			->willReturnCallback(function ($string, $args) {
				return vsprintf($string, $args);
			});
		$this->factory = $this->createMock(IFactory::class);
		$this->factory->expects($this->any())
			->method('get')
			->willReturn($this->l);

		$this->notifier = new Notifier(
			$this->factory,
			$this->userManager,
			$this->manager,
			$this->urlGenerator,
			$this->config
		);
	}

	public function testPrepareWrongApp() {
		$this->expectException(InvalidArgumentException::class);
		/** @var INotification|\PHPUnit_Framework_MockObject_MockObject $notification */
		$notification = $this->createMock(INotification::class);
		$notification->expects($this->once())
			->method('getApp')
			->willReturn('notifications');
		$notification->expects($this->never())
			->method('getSubject');

		$this->notifier->prepare($notification, 'en');
	}

	public function testPrepareWrongSubject() {
		$this->expectException(InvalidArgumentException::class);
		/** @var INotification|\PHPUnit_Framework_MockObject_MockObject $notification */
		$notification = $this->createMock(INotification::class);
		$notification->expects($this->once())
			->method('getApp')
			->willReturn('firstrunwizard');
		$notification->expects($this->once())
			->method('getSubject')
			->willReturn('wrong subject');

		$this->notifier->prepare($notification, 'en');
	}

	/**
	 * @param bool $changeName
	 * @param bool $changeAvatar
	 * @param string $uid
	 * @param string $name
	 * @param string $email
	 * @param IImage|null $avatar
	 * @return IUser|\PHPUnit_Framework_MockObject_MockObject
	 */
	protected function getUserMock($changeName, $changeAvatar, $uid, $name, $email, $avatar) {
		$user = $this->createMock(IUser::class);
		$user->expects($this->atMost(1))
			->method('canChangeDisplayName')
			->willReturn($changeName);
		$user->expects($this->atMost(1))
			->method('canChangeAvatar')
			->willReturn($changeAvatar);
		$user->expects($this->atMost(1))
			->method('getUID')
			->willReturn($uid);
		$user->expects($this->atMost(1))
			->method('getDisplayName')
			->willReturn($name);
		$user->expects($this->atMost(1))
			->method('getEMailAddress')
			->willReturn($email);
		$user->expects($this->atMost(1))
			->method('getAvatarImage')
			->willReturn($avatar);
		return $user;
	}

	public function dataPrepare() {
		return [
			['en', 'user', false, false, 'Changed Name', 'Changed Email', $this->createMock(IImage::class), false],
			['en', 'user', true, true, 'Changed Name', 'Changed Email', $this->createMock(IImage::class), false],
			['en', 'user', true, true, 'user', 'Changed Email', $this->createMock(IImage::class), $this->stringContains('full name')], // No name
			['en', 'user', false, true, 'user', 'Changed Email', $this->createMock(IImage::class), false], // No name - but stuck with it
			['en', 'user', true, true, 'Changed Name', '', $this->createMock(IImage::class), $this->stringContains('email')], // No email
			['de', 'user2', true, true, 'Changed Name', 'Changed Email', null, $this->stringContains('picture')], // No avatar
			['de', 'user2', false, false, 'Changed Name', 'Changed Email', null, false], // No avatar - but stuck with it
		];
	}

	/**
	 * @dataProvider dataPrepare
	 */
	public function testPrepare($language, $user, $changeName, $changeAvatar, $name, $email, $avatar, $subjectContains) {
		/** @var \OCP\Notification\INotification|\PHPUnit_Framework_MockObject_MockObject $notification */
		$notification = $this->createMock(INotification::class);

		$notification->expects($this->once())
			->method('getApp')
			->willReturn('firstrunwizard');
		$notification->expects($this->once())
			->method('getSubject')
			->willReturn('profile');
		$notification->expects($this->once())
			->method('getUser')
			->willReturn($user);

		$this->userManager->expects($this->once())
			->method('get')
			->willReturn($this->getUserMock($changeName, $changeAvatar, $user, $name, $email, $avatar));

		if ($subjectContains === false) {
			$this->manager->expects($this->once())
				->method('markProcessed')
				->with($notification);

			$this->urlGenerator->expects($this->never())
				->method('linkToRouteAbsolute');

			$notification->expects($this->never())
				->method('setParsedSubject');
			$notification->expects($this->never())
				->method('setLink');
		} else {
			$this->manager->expects($this->never())
				->method('markProcessed');

			$this->factory->expects($this->once())
				->method('get')
				->with('firstrunwizard', $language)
				->willReturn($this->l);

			$this->urlGenerator->expects($this->once())
				->method('linkToRouteAbsolute')
				->with('settings.PersonalSettings.index')
				->willReturn('https://example.org/settings/user');

			$notification->expects($this->once())
				->method('setParsedSubject')
				->with($subjectContains)
				->willReturnSelf();
			$notification->expects($this->once())
				->method('setLink')
				->with($this->stringEndsWith('/settings/user'))
				->willReturnSelf();
		}

		try {
			$return = $this->notifier->prepare($notification, $language);
			$this->assertEquals($notification, $return);
		} catch (\Exception $exception) {
			if ($subjectContains === false) {
				$this->assertInstanceOf(InvalidArgumentException::class, $exception);
			} else {
				throw $exception;
			}
		}
	}
}
