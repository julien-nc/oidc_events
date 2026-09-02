<?php

namespace OCA\OidcEvents\AppInfo;

use OCA\OidcEvents\Listener\TokenObtainedListener;
use OCA\OidcEvents\Listener\TokenRefreshedListener;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

class Application extends App implements IBootstrap {
	public const APP_ID = 'oidc_events';

	// TODO: add UserObtainedTokenEvent in user_oidc, it is emitted on login and on refresh, it contains the user ID
	// it has a isRefresh attribute

	public function __construct(array $urlParams = []) {
		parent::__construct(self::APP_ID, $urlParams);
	}

	public function register(IRegistrationContext $context): void {
		if (class_exists('OCA\\UserOIDC\\Event\\TokenRefreshedEvent')) {
			$context->registerEventListener(\OCA\UserOIDC\Event\TokenRefreshedEvent::class, TokenRefreshedListener::class);
		}
		if (class_exists('OCA\\UserOIDC\\Event\\TokenObtainedEvent')) {
			$context->registerEventListener(\OCA\UserOIDC\Event\TokenObtainedEvent::class, TokenObtainedListener::class);
		}
	}

	public function boot(IBootContext $context): void {
	}
}
