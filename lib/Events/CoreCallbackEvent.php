<?php
namespace OCA\ClubSuiteCore\Events;

use OCP\EventDispatcher\Event;

/**
 * CoreCallbackEvent
 *
 * Event that carries a callback which receivers can trigger to provide a response.
 *
 * @since 1.0.0
 */
class CoreCallbackEvent extends Event {
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
    public function getCallback(): ?callable { return $this->callback; }

    public function triggerCallback($data): void {
        if (is_callable($this->callback)) {
            ($this->callback)($data);
        }
    }
}
