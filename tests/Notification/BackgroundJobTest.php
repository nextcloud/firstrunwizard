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
 * @group DB
 */
class BackgroundJobTest extends TestCase {
	protected ITimeFactory $timeFactory;
	protected IManager $notificationManager;
	protected BackgroundJob $job;

	protected function setUp(): void {
		parent::setUp();
		$this->timeFactory = $this->createMock(ITimeFactory::class);
		$this->notificationManager = $this->createMock(IManager::class);
		$this->job = new BackgroundJob(
			$this->timeFactory,
			$this->notificationManager,
		);
	}

	public function dataRun() {
		return [
			['user1', 1, false],
			['user2', 0, true],
		];
	}

	/**
	 * @dataProvider dataRun
	 * @param string $user
	 * @param int $count
	 * @param bool $notify
	 */
	public function testRun($user, $count, $notify) {
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
