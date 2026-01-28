<?php
namespace OCA\ClubSuiteCore\Listener;

use OCA\ClubSuiteCore\Events\CoreRequestDataEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;

/**
 * Example RequestDataEvent listener for Core
 */
class CoreRequestDataEventListener implements IEventListener {
    public function handle(Event $event): void {
        if (!($event instanceof CoreRequestDataEvent)) {
            return;
        }
        // Collect or compute data and respond via the provided callback
        $data = [
            'app' => 'Core',
            'timestamp' => time(),
            'info' => 'example data from Core'
        ];
        $event->respond($data);
    }
}
