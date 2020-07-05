<?php declare(strict_types=1);

require_once('LRUCache.php');

class LRUCacheTest
{
    /**
     * @return void
     */
    public static function testLRUCache(): void
    {
        $cache = new LRUCache(2);

        $cache->put('user1', 'data1', 10);
        var_dump($cache->get('user1')); // 'data1'
        sleep(10);
        $cache->put('user2', 'data2', 60);
        $cache->put('user3', 'data3', 60);

        var_dump($cache->has('user1')); // false

        var_dump($cache->has('user2')); // true
        var_dump($cache->has('user3')); // true

        var_dump($cache->get('user2')); // data2
        $cache->put('user4', 'data4', 60);
        var_dump($cache->has('user3')); // false
        var_dump($cache->has('user2')); // true
        var_dump($cache->has('user4')); // true
    }
}

LRUCacheTest::testLRUCache();