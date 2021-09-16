<?php

/**
 * TechDivision\Import\Dbal\Repositories\Finders\CachedUniqueFinderFactory
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
use TechDivision\Import\Dbal\Repositories\FinderAwareRepositoryInterface;

/**
 * Factory for cached unique finder instances.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class CachedUniqueFinderFactory extends UniqueFinderFactory
{

    /**
     * The cache adapter instance.
     * .
     * @var \TechDivision\Import\Cache\CacheAdapterInterface
     */
    protected $cacheAdapter;

    /**
     * Initialize the repository with the passed cache adapter instance.
     * .
     * @param \TechDivision\Import\Cache\CacheAdapterInterface $cacheAdaper The cache adapter instance
     */
    public function __construct(CacheAdapterInterface $cacheAdaper)
    {
        $this->cacheAdapter = $cacheAdaper;
    }

    /**
     * Return's the cache adapter instance.
     *
     * @return \TechDivision\Import\Cache\CacheAdapterInterface The cache adapter instance
     */
    public function getCacheAdapter()
    {
        return $this->cacheAdapter;
    }

    /**
     * Initialize's and return's a new finder instance.
     *
     * @param \TechDivision\Import\Dbal\Repositories\FinderAwareRepositoryInterface $repository The repository instance to create the finder for
     * @param string                                                                $key        The key of the prepared statement
     *
     * @return \TechDivision\Import\Dbal\Repositories\Finders\FinderInterface The finder instance
     */
    public function createFinder(FinderAwareRepositoryInterface $repository, $key)
    {
        return new CachedUniqueFinder(parent::createFinder($repository, $key), $this->getCacheAdapter());
    }
}
