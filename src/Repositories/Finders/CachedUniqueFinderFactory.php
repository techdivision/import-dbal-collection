<?php

/**
 * TechDivision\Import\Dbal\Repositories\Finders\CachedUniqueFinderFactory
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
use TechDivision\Import\Dbal\Repositories\FinderAwareRepositoryInterface;

/**
 * Factory for cached unique finder instances.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
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
