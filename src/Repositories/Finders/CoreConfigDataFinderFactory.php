<?php
/**
 * Copyright (c) 2022 TechDivision GmbH
 * All rights reserved
 *
 * This product includes proprietary software developed at TechDivision GmbH, Germany
 * For more information see https://www.techdivision.com/
 *
 * To obtain a valid license for using this software please contact us at
 * license@techdivision.com
 */
declare(strict_types=1);

namespace TechDivision\Import\Dbal\Collection\Repositories\Finders;

use TechDivision\Import\Dbal\Configuration\ConfigurationInterface;
use TechDivision\Import\Dbal\Repositories\FinderAwareRepositoryInterface;
use TechDivision\Import\Dbal\Repositories\Finders\FinderFactoryInterface;
use \Doctrine\Common\Collections\Collection;

/**
 * Factory implementations for core config data finder instances.
 *
 * @author    MET <met@techdivision.com>
 * @copyright 2022 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class CoreConfigDataFinderFactory implements FinderFactoryInterface
{
    /** @var ConfigurationInterface */
    public $configuration;

    /** @var \Doctrine\Common\Collections\Collection */
    private $systemLoggers;

    /**
     * The constructor to initialize the instance.
     *
     * @param \TechDivision\Import\Dbal\Configuration\ConfigurationInterface $configuration The configuration instance
     * @param \Doctrine\Common\Collections\Collection                        $systemLoggers The systemLoggers instance
     */
    public function __construct(ConfigurationInterface $configuration, Collection $systemLoggers)
    {
        $this->configuration = $configuration;
        $this->systemLoggers = $systemLoggers;
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
        return new CoreConfigDataFinder(
            $key,
            $repository->getPrimaryKeyName(),
            $repository->getEntityName(),
            $this->configuration,
            $this->systemLoggers
        );
    }
}
