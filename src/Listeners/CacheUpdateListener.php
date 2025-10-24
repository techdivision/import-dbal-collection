<?php

/**
 * TechDivision\Import\Dbal\Collection\Listeners\CacheUpdateListener
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Listeners;

use League\Event\EventInterface;
use League\Event\AbstractListener;
use TechDivision\Import\Cache\CacheAdapterInterface;
use TechDivision\Import\Dbal\Actions\CachedActionInterface;

/**
 * A listener implementation that updates the cache after a row has been updated.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
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
     * @param \League\Event\EventInterface                            $event  The event that triggered the listener
     * @param \TechDivision\Import\Dbal\Actions\CachedActionInterface|null $action The action instance that triggered the event
     * @param array                                                   $row    The row to be cached
     *
     * @return void
     */
    public function handle(EventInterface $event, ?CachedActionInterface $action = null, array $row = array())
    {

        // remove an existing product varchar attribute from the cache to allow reloading it
        if ($this->cacheAdapter->isCached($uniqueKey = array($action->getCacheKey() => $row[$action->getPrimaryKeyMemberName()]))) {
            $this->cacheAdapter->removeCache($uniqueKey);
        }
    }
}
