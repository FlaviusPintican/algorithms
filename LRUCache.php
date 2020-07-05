<?php declare(strict_types=1);

/**
 * Class LRUCache
 * @see https://github.com/rogeriopvl/php-lrucache/blob/master/src/LRUCache/LRUCache.php
 */
class LRUCache
{
    /**
     * @var int
     */
    private int $capacity = 0;

    /**
     * @var array
     */
    private array $cacheList = [];

    /**
     * @var int
     */
    private int $currentSize = 0;

    /**
     * @var array
     */
    private array $countKeyValues = [];

    /**
     * @param int $capacity
     */
    public function __construct(int $capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $expire
     *
     * @return void
     */
    public function put(string $key, $value, int $expire): void
    {
        if ($this->capacity === 0) {
            return;
        }

        if ($this->currentSize === $this->capacity) {
            $this->remove($this->getMinimumOccurrenceKey());
            $this->currentSize--;
        }

        $this->cacheList[$key] = [
            'value' => $value,
            'expire' => (new DateTime())->getTimestamp() + $expire
        ];

        $this->updateCountKeyValues($key, 0);
        $this->currentSize++;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if (!$this->has($key)) {
            throw new Exception('No item found');
        }

        $this->updateCountKeyValues($key, 1);

        return $this->cacheList[$key]['value'];
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        $item = $this->cacheList[$key]['value'] ?? null;

        if (null !== $item && !$this->isExpired($key)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @return void
     */
    public function remove(string $key): void
    {
        if (isset($this->cacheList[$key])) {
            unset($this->cacheList[$key], $this->countKeyValues[$key]);
        }
    }

    /**
     * @return int
     */
    public function size(): int
    {
        return $this->currentSize;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    private function isExpired(string $key): bool
    {
        if ($this->cacheList[$key]['expire'] > (new DateTime())->getTimestamp()) {
            return false;
        }

        $this->remove($key);

        return true;
    }

    /**
     * @param string $key
     * @param int $nr
     *
     * @return void
     */
    private function updateCountKeyValues(string $key, int $nr): void
    {
        $this->countKeyValues[$key] = isset($this->countKeyValues[$key]) ? $this->countKeyValues[$key] + $nr : $nr;
    }

    /**
     * @return string
     */
    private function getMinimumOccurrenceKey(): string
    {
        $minKey = '';
        $nrOccurrence = 0;

        foreach ($this->countKeyValues as $key => $value) {
            if ($this->isExpired($key)) {
                continue;
            }

            if ($value <= $nrOccurrence
                || ($value === $nrOccurrence && $this->cacheList[$minKey]['expire'] < $this->cacheList[$key]['expire'])
            ) {
                $minKey = $key;
                $nrOccurrence = $value;
            }
        }

        if (count($this->countKeyValues) < $this->capacity) {
            return '';
        }

        return $minKey;
    }
}
