<?php
namespace OCA\ClubSuiteCore\Events;

use OCP\EventDispatcher\Event;

/**
 * CoreBasicEvent
 *
 * Fire-and-forget event emitted by Core.
 *
 * @since 1.0.0
 */
class CoreBasicEvent extends Event {
    private string $id;
    private int $timestamp;
    private array $payload;

    public function __construct(string $id, int $timestamp, array $payload = []) {
        $this->id = $id;
        $this->timestamp = $timestamp;
        $this->payload = $payload;
    }

    public function getId(): string { return $this->id; }
    public function getTimestamp(): int { return $this->timestamp; }
    public function getPayload(): array { return $this->payload; }
}
