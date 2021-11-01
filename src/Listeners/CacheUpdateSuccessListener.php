<?php

/**
 * TechDivision\Import\Dbal\Collection\Listeners\CacheUpdateListener
 *
 * Copyright (c) 2021 TechDivision GmbH.
 *
 * All rights reserved.
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany.
 * For more information see http://www.techdivision.com/.
 *
 * To obtain a valid license for using this software please contact us at
 * license@techdivision.com.
 */

namespace TechDivision\Import\Dbal\Collection\Listeners;

use League\Event\EventInterface;
use League\Event\AbstractListener;
use TechDivision\Import\Cache\CacheAdapterInterface;
use TechDivision\Import\Dbal\Actions\CachedActionInterface;
use TechDivision\Import\Dbal\Utils\EntityStatus;

/**
 * A listener implementation that updates the cache after a row has been updated.
 *
 * @link      http://www.techdivision.com/
 * @author    Martin Eisenführer <m.eisenfuehrer@techdivision.com>
 * @copyright Copyright (c) 2021 TechDivision GmbH (http://www.techdivision.com)
 */
class CacheUpdateSuccessListener extends AbstractListener
{

    /**
     * The cache adapter instance.
     *
     * @var \TechDivision\Import\Cache\CacheAdapterInterface
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
     * @param \League\Event\EventInterface                               $event  The event that triggered the listener
     * @param \TechDivision\Import\Dbal\Actions\CachedActionInterface $action The action instance that triggered the event
     * @param array                                                      $row    The row to be cached
     *
     * @return void
     */
    public function handle(EventInterface $event, CachedActionInterface $action = null, array $row = array())
    {

        // remove an existing product varchar attribute from the cache to allow reloading it
        if (!$this->cacheAdapter->isCached($uniqueKey = array($action->getCacheKey() => $row[$action->getPrimaryKeyMemberName()]))) {
            unset($row[EntityStatus::MEMBER_NAME]);
            $this->cacheAdapter->toCache($uniqueKey, $row);
        }
    }
}
