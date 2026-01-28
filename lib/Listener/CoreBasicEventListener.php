<?php
namespace OCA\ClubSuiteCore\Listener;

use OCA\ClubSuiteCore\Events\CoreBasicEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;

/**
 * Example BasicEvent listener for Core
 */
class CoreBasicEventListener implements IEventListener {
    public function handle(Event $event): void {
        if (!($event instanceof CoreBasicEvent)) {
            return;
        }
        // Example: log that we received the event. Keep logic minimal to avoid dependencies.
        error_log('CoreBasicEvent received in Core: ' . $event->getId());
    }
}
