<?php

/**
 * TechDivision\Import\Dbal\Collection\Repositories\Finders\SimpleFinderFactory
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
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Repositories\Finders;

use TechDivision\Import\Dbal\Repositories\FinderAwareRepositoryInterface;
use TechDivision\Import\Dbal\Repositories\Finders\FinderFactoryInterface;

/**
 * Factory implementations for simple finder instances.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class SimpleFinderFactory implements FinderFactoryInterface
{

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
        return new SimpleFinder(
            $repository->getConnection()->prepare(
                $repository->loadStatement($key)
            ),
            $key,
            $repository->getPrimaryKeyName(),
            $repository->getEntityName()
        );
    }
}
