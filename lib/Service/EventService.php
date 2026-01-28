<?php
namespace OCA\ClubSuiteCore\Service;

use OCP\EventDispatcher\IEventDispatcher;
use OCA\ClubSuiteCore\Events\CoreBasicEvent;
use OCA\ClubSuiteCore\Events\CoreCallbackEvent;
use OCA\ClubSuiteCore\Events\CoreRequestDataEvent;

/**
 * EventService provides a small API to dispatch inter-app events from this app.
 */
class EventService {
    private IEventDispatcher $dispatcher;

    public function __construct(IEventDispatcher $dispatcher) {
        $this->dispatcher = $dispatcher;
    }

    public function dispatchBasicEvent(array $payload): void {
        $event = new CoreBasicEvent(uniqid('core_', true), time(), $payload);
        $this->dispatcher->dispatch($event);
    }

    public function dispatchCallbackEvent(array $payload, callable $callback): void {
        $event = new CoreCallbackEvent(uniqid('core_cb_', true), time(), $payload, $callback);
        $this->dispatcher->dispatch($event);
    }

    public function dispatchRequestDataEvent(callable $callback): void {
        $event = new CoreRequestDataEvent(uniqid('core_req_', true), time(), [], $callback);
        $this->dispatcher->dispatch($event);
    }
}
