<?php

/**
 * TechDivision\Import\Dbal\Cache\Repositories\Finders\CachedUniqueEntityFinder
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Repositories\Finders;

use TechDivision\Import\Cache\CacheAdapterInterface;
use TechDivision\Import\Dbal\Repositories\Finders\EntityFinderInterface;

/**
 * A cached unqiue entity finder implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class CachedUniqueEntityFinder implements EntityFinderInterface
{

    /**
     * The finder instance to cache
     *
     * @var \TechDivision\Import\Dbal\Repositories\Finders\EntityFinderInterface
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
     * @param \TechDivision\Import\Dbal\Repositories\Finders\EntityFinderInterface $finder       The entity finder instance to cache
     * @param \TechDivision\Import\Cache\CacheAdapterInterface                     $cacheAdapter The cache adapter instance
     */
    public function __construct(EntityFinderInterface $finder, CacheAdapterInterface $cacheAdapter)
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
     * Return's the entity unique key name.
     *
     * @return string The name of the entity's unique key
     */
    public function getUniqueKeyName()
    {
        return $this->finder->getUniqueKeyName();
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

        // prepare the cache key
        $cacheKey = $this->cacheAdapter->cacheKey(array($this->getKey() => $params), false);

        // query whether or not the item has already been cached
        if ($this->cacheAdapter->isCached($cacheKey)) {
            return $this->cacheAdapter->fromCache($cacheKey);
        }

        // query whether or not the product varchar value is available in the database
        if ($entity = $this->finder->find($params)) {
            // prepare the unique cache key for the EAV attribute option value
            $uniqueKey = array($this->getEntityName() => $entity[$this->getUniqueKeyName()]);
            // add the EAV attribute option value to the cache, register the cache key reference as well
            $this->cacheAdapter->toCache($uniqueKey, $entity, array($cacheKey => $uniqueKey));
        }

        // finally, return it
        return $entity;
    }

    /**
     * Remove the item with the passed key and all its references from the cache.
     * to get the corrctly entity after update custom_option
     *
     * @param array $params The finder params
     *
     * @return array The finder result
     */
    public function removeCache(array $params = array())
    {

        // prepare the cache key
        $cacheKey = $this->cacheAdapter->cacheKey(array($this->getKey() => $params), false);

        // query whether or not the item has already been cached
        if ($this->cacheAdapter->isCached($cacheKey)) {
            return $this->cacheAdapter->removeCache($cacheKey);
        }
    }
}
