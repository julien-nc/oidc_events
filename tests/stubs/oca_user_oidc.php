<?php

namespace OCA\UserOIDC\Event {

	use OCP\EventDispatcher\Event;

	class UserObtainedTokenEvent extends Event {
		/**
		 * @return string The user ID of the user who obtained the token
		 */
		public function getUserId(): string {
		}

		/**
		 * This old token is set only when the token is refreshed
		 * @return array|null The old token that has been refreshed
		 */
		public function getOldToken(): ?array {
		}

		/**
		 * @return array The freshly obtained token
		 */
		public function getNewToken(): array {
		}

		/**
		 * @return Provider The related Oidc provider
		 */
		public function getProvider(): Provider {
		}

		/**
		 * The decoded discovery data from the discovery endpoint payload
		 * @return array The discovery data
		 */
		public function getDiscovery(): array {
		}
	}

}
