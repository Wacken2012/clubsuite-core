<?php
namespace OCA\ClubSuiteCore\Listener;

use OCA\ClubSuiteCore\Events\CoreCallbackEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;

/**
 * Example CallbackEvent listener for Core
 */
class CoreCallbackEventListener implements IEventListener {
    public function handle(Event $event): void {
        if (!($event instanceof CoreCallbackEvent)) {
            return;
        }
        // Process payload and trigger callback to acknowledge or return data
        $payload = $event->getPayload();
        // Example response
        $response = ['handledBy' => 'Core', 'payloadSummary' => count($payload)];
        $event->triggerCallback($response);
    }
}
