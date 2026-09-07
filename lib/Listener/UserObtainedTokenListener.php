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
use OCP\Security\ICrypto;
use OCP\Server;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Log\LoggerInterface;

/**
 * @template-implements IEventListener<UserObtainedTokenEvent>
 */
class UserObtainedTokenListener implements IEventListener {

	public function __construct(
		private LoggerInterface $logger,
		private ICrypto $crypto,
	) {
	}

	public function handle(Event $event): void {
		if (!($event instanceof UserObtainedTokenEvent)) {
			return;
		}

		if ($event->getOldToken() !== null) {
			$this->logger->info(
				'[OidcEvents] Token refreshed', [
					'user_id' => $event->getUserId(),
					'expires_in' => $event->getNewToken()['expires_in'],
					'refresh_expires_in' => $event->getNewToken()['refresh_expires_in'],
				]
			);
		} else {
			$this->logger->info(
				'[OidcEvents] Token obtained on login', [
					'user_id' => $event->getUserId(),
					'expires_in' => $event->getNewToken()['expires_in'],
					'refresh_expires_in' => $event->getNewToken()['refresh_expires_in'],
				]
			);
		}

		$userId = $event->getUserId();
		try {
			$mailAccountMapper = Server::get(\OCA\Mail\Db\MailAccountMapper::class);
		} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
			$this->logger->info('[OidcEvents] MailAccountMapper not found', ['exception' => $e]);
			return;
		}
		$accounts = $mailAccountMapper->findByUserId($userId);
		if (count($accounts) === 0) {
			$this->logger->info('[OidcEvents] Mail account not found');
		}
		$account = $accounts[0];
		$this->logger->debug('[OidcEvents] Mail account was found', [
			'user_id' => $userId,
			'account_id' => $account->getId(),
			'account_name' => $account->getName(),
			'account_email' => $account->getEmail(),
			'account_inbound_host' => $account->getInboundHost(),
		]);

		$password = $event->getNewToken()['access_token'];
		$encryptedPassword = $this->crypto->encrypt($password);

		$account->setInboundPassword($encryptedPassword);
		$account->setOutboundPassword($encryptedPassword);
		$mailAccountMapper->update($account);
		$this->logger->info('[OidcEvents] PASSWORD was set', ['user_id' => $userId]);
	}
}
