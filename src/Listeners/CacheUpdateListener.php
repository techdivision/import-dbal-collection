<?php

/**
 * TechDivision\Import\Dbal\Listeners\CacheUpdateListener
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

namespace TechDivision\Import\Dbal\Listeners;

use League\Event\EventInterface;
use League\Event\AbstractListener;
use TechDivision\Import\Cache\CacheAdapterInterface;
use TechDivision\Import\Dbal\Actions\CachedActionInterface;

/**
 * A listener implementation that updates the cache after a row has been updated.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class CacheUpdateListener extends AbstractListener
{

    /**
     * The cache adapter instance.
     *
     * @var \TechDivision\Import\\Cache\CacheAdapterInterface
     */
    protected $cacheAdapter;

    /**
     * Initializes the listener with the cache adapter and the system loggers.
     *
     * @param \TechDivision\Import\Cache\CacheAdapterInterface $cacheAdapter The cache adapter instance
     */
    public function __construct(CacheAdapterInterface $cacheAdapter)
    {
        $this->cacheAdapter = $cacheAdapter;
    }

    /**
     * Handle the event.
     *
     * @param \League\Event\EventInterface                             $event  The event that triggered the listener
     * @param \TechDivision\Import\Cache\Actions\CachedActionInterface $action The action instance that triggered the event
     * @param array                                                    $row    The row to be cached
     *
     * @return void
     */
    public function handle(EventInterface $event, CachedActionInterface $action = null, array $row = array())
    {

        // remove an existing product varchar attribute from the cache to allow reloading it
        if ($this->cacheAdapter->isCached($uniqueKey = array($action->getCacheKey() => $row[$action->getPrimaryKeyMemberName()]))) {
            $this->cacheAdapter->removeCache($uniqueKey);
        }
    }
}
