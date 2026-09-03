<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\OidcEvents\Listener;

use OCA\UserOIDC\Event\UserObtainedTokenEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use Psr\Log\LoggerInterface;

/**
 * @template-implements IEventListener<UserObtainedTokenEvent>
 */
class UserObtainedTokenListener implements IEventListener {

	public function __construct(
		private LoggerInterface $logger,
	) {
	}

	public function handle(Event $event): void {
		if (!($event instanceof UserObtainedTokenEvent)) {
			return;
		}

		if ($event->getOldToken() !== null) {
			$this->logger->info('[OidcEvents] Token refresh', ['user_id' => $event->getUserId(), 'event' => $event]);
		} else {
			$this->logger->info('[OidcEvents] Token obtained', ['user_id' => $event->getUserId(), 'event' => $event]);
		}
	}
}
