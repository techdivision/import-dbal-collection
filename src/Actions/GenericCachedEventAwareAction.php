<?php

/**
 * TechDivision\Import\Dbal\Cache\Actions\GenericCachedEventAwareAction
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Actions;

use League\Event\EmitterInterface;
use TechDivision\Import\Dbal\Actions\ActionInterface;
use TechDivision\Import\Cache\Utils\CacheKeysInterface;
use TechDivision\Import\Dbal\Actions\CachedActionInterface;

/**
 * An generic action implementation that extends CRUD and event handling with cache functionality.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class GenericCachedEventAwareAction extends GenericEventAwareAction implements CachedActionInterface
{

    /**
     * The cache key instance.
     *
     * @var \TechDivision\Import\Cache\Utils\CacheKeysInterface
     */
    protected $cacheKeys;

    /**
     * Initializes the action with the passed instances.
     *
     * @param \League\Event\EmitterInterface                      $emitter   The event emitter instance
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface   $action    The action that has to be cached
     * @param \TechDivision\Import\Cache\Utils\CacheKeysInterface $cacheKeys The cache keys instance
     */
    public function __construct(EmitterInterface $emitter, ActionInterface $action, CacheKeysInterface $cacheKeys)
    {

        // pass the emitter and the action to the parent constructor
        parent::__construct($emitter, $action);

        // set the cache keys instance
        $this->cacheKeys = $cacheKeys;
    }

    /**
     * Return's the primary key of the entity to persist.
     *
     * @return string The primary key name
     */
    public function getCacheKey()
    {
        return $this->cacheKeys->getCacheKey();
    }
}
