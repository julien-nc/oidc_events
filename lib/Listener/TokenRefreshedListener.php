<?php

declare(strict_types=1);

/**
 * SPDX-FileCopyrightText: 2026 Nextcloud GmbH and Nextcloud contributors
 * SPDX-License-Identifier: AGPL-3.0-or-later
 */

namespace OCA\OidcEvents\Listener;

use OCA\UserOIDC\Event\TokenRefreshedEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;
use Psr\Log\LoggerInterface;

/**
 * @template-implements IEventListener<TokenRefreshedEvent>
 */
class TokenRefreshedListener implements IEventListener {

	public function __construct(
		private LoggerInterface $logger,
	) {
	}

	public function handle(Event $event): void {
		if (!($event instanceof TokenRefreshedEvent)) {
			return;
		}

		$this->logger->info('[OidcEvents] Token refreshed', ['event' => $event]);
	}
}
