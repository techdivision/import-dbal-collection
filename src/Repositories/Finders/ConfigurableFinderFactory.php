<?php

/**
 * TechDivision\Import\Dbal\Repositories\Finders\ConfigurableFinderFactory
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

use TechDivision\Import\Dbal\Configuration\ConfigurationInterface;
use Symfony\Component\DependencyInjection\TaggedContainerInterface;
use TechDivision\Import\Dbal\Repositories\FinderAwareRepositoryInterface;

/**
 * Factory for finder instances.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class ConfigurableFinderFactory implements FinderFactoryInterface
{

    /**
     * The DI container builder instance.
     *
     * @var \Symfony\Component\DependencyInjection\TaggedContainerInterface
     */
    protected $container;

    /**
     * The configuration instance.
     *
     * @var \TechDivision\Import\Dbal\Configuration\ConfigurationInterface
     */
    protected $configuration;

    /**
     * The constructor to initialize the instance.
     *
     * @param \Symfony\Component\DependencyInjection\TaggedContainerInterface $container     The container instance
     * @param \TechDivision\Import\Dbal\Configuration\ConfigurationInterface  $configuration The configuration instance
     */
    public function __construct(TaggedContainerInterface $container, ConfigurationInterface $configuration)
    {
        $this->container = $container;
        $this->configuration = $configuration;
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
        return $this->container->get($this->configuration->getFinderMappingByKey($key))->createFinder($repository, $key);
    }
}
