<?php

/**
 * TechDivision\Import\Dbal\Repositories\Finders\CachedYieldedFinder
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Repositories\Finders;

use TechDivision\Import\Cache\CacheAdapterInterface;

/**
 * A cached yielded finder implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class CachedYieldedFinder implements FinderInterface
{

    /**
     * The finder instance to cache
     *
     * @var \TechDivision\Import\Dbal\Repositories\Finders\FinderInterface
     */
    protected $finder;

    /**
     * The cache adapter instance.
     *
     * @var \TechDivision\Import\Cache\CacheAdapterInterface
     */
    protected $cacheAdapter;

    /**
     * Initialize the repository with the passed connection and utility class name.
     *
     * @param \TechDivision\Import\Dbal\Repositories\Finders\FinderInterface $finder       The finder instance to cache
     * @param \TechDivision\Import\Cache\CacheAdapterInterface               $cacheAdapter The cache adapter instance
     */
    public function __construct(FinderInterface $finder, CacheAdapterInterface $cacheAdapter)
    {
        $this->finder = $finder;
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * Return's the finder's unique key.
     *
     * @return string The unique key
     */
    public function getKey()
    {
        return $this->finder->getKey();
    }

    /**
     * Return's the entity's primary key name.
     *
     * @return string The entity's primary key name
     */
    public function getPrimaryKeyName()
    {
        return $this->finder->getPrimaryKeyName();
    }

    /**
     * Return's the finder's entity name.
     *
     * @return string The finder's entity name
     */
    public function getEntityName()
    {
        return $this->finder->getEntityName();
    }

    /**
     * Executes the finder with the passed parameters.
     *
     * @param array $params The finder params
     *
     * @return array The finder result
     */
    public function find(array $params = array())
    {

        // initialize the array for the unique keys
        $uniqueKeys = array();

        // prepare the cache key
        $cacheKey = $this->cacheAdapter->cacheKey(array($this->getKey() => $params), false);

        // query whether or not the item has already been cached
        if ($this->cacheAdapter->isCached($cacheKey)) {
            foreach ($this->cacheAdapter->fromCache($cacheKey) as $uniqueKey) {
                yield $this->cacheAdapter->fromCache($uniqueKey);
            }
            return;
        }

        // fetch the values and return them
        foreach ($this->finder->find($params) as $record) {
            // prepare the unique cache key for the product varchar attribute
            $uniqueKeys[] = $uniqueKey = array($this->getEntityName() => $record[$this->getPrimaryKeyName()]);
            // add the attribute to the cache
            $this->cacheAdapter->toCache($uniqueKey, $record);
            // return the record
            yield $record;
        }

        // cache the unique keys for the cache key
        $this->cacheAdapter->toCache($cacheKey, $uniqueKeys);
    }
}
