<?php

namespace Tests;

use Mindy\Cache\FileCache;
use Tests\CacheTestCase;

/**
 * Class for testing file cache backend
 * @group caching
 */
class FileCacheTest extends CacheTestCase
{
    private $_cacheInstance = null;

    /**
     * @return \Mindy\Cache\FileCache
     */
    protected function getCacheInstance()
    {
        if ($this->_cacheInstance === null) {
            $this->_cacheInstance = new FileCache([
                'cachePath' => __DIR__ . '/../Runtime/Cache/'
            ]);
        }
        return $this->_cacheInstance;
    }

    public function testExpire()
    {
        $cache = $this->getCacheInstance();

        self::$time = \time();
        $this->assertTrue($cache->set('expire_test', 'expire_test', 2));
        static::$time++;
        $this->assertEquals('expire_test', $cache->get('expire_test'));
        static::$time++;
    }

    public function testExpireAdd()
    {
        $cache = $this->getCacheInstance();

        self::$time = \time();
        $this->assertTrue($cache->add('expire_testa', 'expire_testa', 2));
        self::$time++;
        $this->assertEquals('expire_testa', $cache->get('expire_testa'));
        self::$time++;
        $this->assertFalse($cache->get('expire_testa'));
    }
}
