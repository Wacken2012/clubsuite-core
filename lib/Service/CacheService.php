<?php
namespace OCA\ClubSuiteCore\Service;

use OCP\ICache;

class CacheService {
    private ICache $cache;

    public function __construct(ICache $cache) {
        $this->cache = $cache;
    }

    public function get(string $key) {
        return $this->cache->get($key);
    }

    public function set(string $key, $value, int $ttl = 3600): void {
        $this->cache->set($key, $value, $ttl);
    }

    public function delete(string $key): void {
        $this->cache->delete($key);
    }
}
