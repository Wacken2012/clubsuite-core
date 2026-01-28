<?php

declare(strict_types=1);

namespace OCA\ClubSuiteCore\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCA\ClubSuiteCore\Listener\CoreBasicEventListener;
use OCA\ClubSuiteCore\Listener\CoreCallbackEventListener;
use OCA\ClubSuiteCore\Listener\CoreRequestDataEventListener;
use OCA\ClubSuiteCore\Events\CoreBasicEvent;
use OCA\ClubSuiteCore\Events\CoreCallbackEvent;
use OCA\ClubSuiteCore\Events\CoreRequestDataEvent;
use OCP\IL10N;
use OCP\INavigationManager;
use OCP\IURLGenerator;

class Application extends App implements IBootstrap {
    public const APP_ID = 'clubsuite-core';

    public function __construct(array $urlParams = []) {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void {
        // Register event listeners for inter-app communication
        $context->registerEventListener(CoreBasicEvent::class, CoreBasicEventListener::class);
        $context->registerEventListener(CoreCallbackEvent::class, CoreCallbackEventListener::class);
        $context->registerEventListener(CoreRequestDataEvent::class, CoreRequestDataEventListener::class);
    }

    public function boot(IBootContext $context): void {
        // Use the app container for app-specific services like IL10N
        $appContainer = $context->getAppContainer();
        $serverContainer = $context->getServerContainer();
        
        // Register navigation entry
        /** @var INavigationManager $navManager */
        $navManager = $serverContainer->get(INavigationManager::class);
        $navManager->add(function () use ($appContainer) {
            /** @var IURLGenerator $urlGenerator */
            $urlGenerator = $appContainer->get(IURLGenerator::class);
            /** @var IL10N $l10n */
            $l10n = $appContainer->get(IL10N::class);
            
            return [
                'id' => self::APP_ID,
                'order' => 10,
                'name' => $l10n->t('Verein'),
                'href' => $urlGenerator->linkToRoute(self::APP_ID . '.page.index'),
                'icon' => $urlGenerator->imagePath(self::APP_ID, 'app.svg'),
            ];
        });
    }
}
