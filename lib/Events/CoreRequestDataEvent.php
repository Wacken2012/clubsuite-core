<?php
namespace OCA\ClubSuiteCore\Events;

use OCP\EventDispatcher\Event;

/**
 * CoreRequestDataEvent
 *
 * Event used to request data from other apps. Receivers should call `respond()` with data.
 *
 * @since 1.0.0
 */
class CoreRequestDataEvent extends Event {
    private string $id;
    private int $timestamp;
    private array $payload;
    private $callback;

    public function __construct(string $id, int $timestamp, array $payload = [], ?callable $callback = null) {
        $this->id = $id;
        $this->timestamp = $timestamp;
        $this->payload = $payload;
        $this->callback = $callback;
    }

    public function getId(): string { return $this->id; }
    public function getTimestamp(): int { return $this->timestamp; }
    public function getPayload(): array { return $this->payload; }

    public function respond($data): void {
        if (is_callable($this->callback)) {
            ($this->callback)($data);
        }
    }
}
