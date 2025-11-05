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
use PHPUnit\Framework\MockObject\MockObject;
use Test\TestCase;

class NotifierTest extends TestCase {
	protected Notifier $notifier;

	protected IConfig&MockObject $config;
	protected IManager&MockObject $manager;
	protected IUserManager&MockObject $userManager;
	protected IFactory&MockObject $factory;
	protected IURLGenerator&MockObject $urlGenerator;
	protected IL10N&MockObject $l;


	protected function setUp(): void {
		$this->manager = $this->createMock(IManager::class);
		$this->userManager = $this->createMock(IUserManager::class);
		$this->urlGenerator = $this->createMock(IURLGenerator::class);
		$this->config = $this->createMock(IConfig::class);
		$this->l = $this->createMock(IL10N::class);
		$this->l->expects($this->any())
			->method('t')
			->willReturnCallback(vsprintf(...));
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

	public function testPrepareWrongApp(): void {
		$this->expectException(InvalidArgumentException::class);
		$notification = $this->createMock(INotification::class);
		$notification->expects($this->once())
			->method('getApp')
			->willReturn('notifications');
		$notification->expects($this->never())
			->method('getSubject');

		$this->notifier->prepare($notification, 'en');
	}

	public function testPrepareWrongSubject(): void {
		$this->expectException(InvalidArgumentException::class);
		$notification = $this->createMock(INotification::class);
		$notification->expects($this->once())
			->method('getApp')
			->willReturn('firstrunwizard');
		$notification->expects($this->once())
			->method('getSubject')
			->willReturn('wrong subject');

		$this->notifier->prepare($notification, 'en');
	}

	protected function getUserMock(bool $changeName, bool $changeAvatar, string $uid, string $name, string $email, ?IImage $avatar): IUser&MockObject {
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

	public static function dataPrepare(): array {
		return [
			['en', 'user', false, false, 'Changed Name', 'Changed Email', true, false],
			['en', 'user', true, true, 'Changed Name', 'Changed Email', true, false],
			['en', 'user', true, true, 'user', 'Changed Email', true, 'full name'], // No name
			['en', 'user', false, true, 'user', 'Changed Email', true, false], // No name - but stuck with it
			['en', 'user', true, true, 'Changed Name', '', true, 'email'], // No email
			['de', 'user2', true, true, 'Changed Name', 'Changed Email', false, 'picture'], // No avatar
			['de', 'user2', false, false, 'Changed Name', 'Changed Email', false, false], // No avatar - but stuck with it
		];
	}

	#[\PHPUnit\Framework\Attributes\DataProvider('dataPrepare')]
	public function testPrepare(string $language, string $user, bool $changeName, bool $changeAvatar, string $name, string $email, bool $hasAvatar, bool|string $subjectContains): void {
		$avatar = $hasAvatar ? $this->createMock(IImage::class) : null;
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
				->with($this->stringContains($subjectContains))
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
