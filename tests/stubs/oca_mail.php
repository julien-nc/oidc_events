<?php

namespace OCA\Mail\Db {

	class MailAccount {
		public function getId(): int {
		}

		public function getName(): string {
		}

		public function getEmail(): string {
		}

		public function getInboundHost(): string {
		}

		public function setInboundPassword(string $password): void {
		}

		public function setOutboundPassword(string $password): void {
		}
	}

	class MailAccountMapper {
		/**
		 * @return MailAccount[]
		 */
		public function findByUserId(string $userId): array {
		}

		public function update(MailAccount $account): MailAccount {
		}
	}

}
