<?php

/**
 * SPDX-FileCopyrightText: 2016 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\FirstRunWizard\Tests\Notification;

use OCA\FirstRunWizard\Notification\BackgroundJob;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\Notification\IManager;
use OCP\Notification\INotification;
use Test\TestCase;

/**
 * Class BackgroundJobTest
 *
 * @package OCA\FirstRunWizard\Tests\Notification
 */
#[\PHPUnit\Framework\Attributes\Group('DB')]
class BackgroundJobTest extends TestCase {
	protected ITimeFactory $timeFactory;
	protected IManager $notificationManager;
	protected BackgroundJob $job;

	protected function setUp(): void {
		$this->timeFactory = $this->createMock(ITimeFactory::class);
		$this->notificationManager = $this->createMock(IManager::class);
		$this->job = new BackgroundJob(
			$this->timeFactory,
			$this->notificationManager,
		);
	}

	public static function dataRun(): array {
		return [
			['user1', 1, false],
			['user2', 0, true],
		];
	}

	#[\PHPUnit\Framework\Attributes\DataProvider('dataRun')]
	public function testRun(string $user, int $count, bool $notify): void {
		$notification = $this->createMock(INotification::class);
		$notification->expects($this->once())
			->method('setApp')
			->with('firstrunwizard')
			->willReturnSelf();
		$notification->expects($this->once())
			->method('setSubject')
			->with('profile')
			->willReturnSelf();
		$notification->expects($this->once())
			->method('setObject')
			->with('user', $user)
			->willReturnSelf();
		$notification->expects($this->once())
			->method('setUser')
			->with($user)
			->willReturnSelf();

		if ($notify) {
			$notification->expects($this->once())
				->method('setDateTime')
				->willReturnSelf();
		} else {
			$notification->expects($this->never())
				->method('setDateTime');
		}

		$this->notificationManager->expects($this->once())
			->method('createNotification')
			->willReturn($notification);
		$this->notificationManager->expects($this->once())
			->method('getCount')
			->willReturn($count);

		$this->invokePrivate($this->job, 'run', [['uid' => $user]]);
	}
}
