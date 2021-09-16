<?php

/**
 * TechDivision\Import\Dbal\Repositories\AbstractFinderRepository
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Repositories;

use TechDivision\Import\Dbal\Connection\ConnectionInterface;
use TechDivision\Import\Dbal\Repositories\Finders\FinderInterface;
use TechDivision\Import\Dbal\Repositories\Finders\FinderFactoryInterface;
use TechDivision\Import\Dbal\Repositories\FinderAwareRepositoryInterface;
use TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface;

/**
 * Abstract repository implementation with finder support.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
abstract class AbstractFinderRepository extends AbstractRepository implements FinderAwareRepositoryInterface
{

    /**
     * The finder factory.
     *
     * @var \TechDivision\Import\Dbal\Repositories\Finders\FinderFactoryInterface
     */
    protected $finderFactory;

    /**
     * The array with the initialized finders.
     *
     * @var array
     */
    protected $finders = array();

    /**
     * Initialize the repository with the passed connection and utility class name.
     * .
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface               $connection             The connection instance
     * @param \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface $sqlStatementRepository The SQL repository instance
     * @param \TechDivision\Import\Dbal\Repositories\Finders\FinderFactoryInterface  $finderFactory          The finder factory instance
     */
    public function __construct(
        ConnectionInterface $connection,
        SqlStatementRepositoryInterface $sqlStatementRepository,
        FinderFactoryInterface $finderFactory
    ) {

        // set the finder factory
        $this->finderFactory = $finderFactory;

        // pass the connection the SQL statement repository to the parent class
        parent::__construct($connection, $sqlStatementRepository);
    }

    /**
     * Add the initialize finder to the repository.
     *
     * @param \TechDivision\Import\Dbal\Repositories\Finders\FinderInterface $finder The finder instance to add
     *
     * @return void
     */
    public function addFinder(FinderInterface $finder)
    {
        $this->finders[$finder->getKey()] = $finder;
    }

    /**
     * Return's the finder instance with the passed key.
     *
     * @param string $key The key of the finder to return
     *
     * @return \TechDivision\Import\Dbal\Repositories\Finders\FinderInterface The finder instance
     * @throws \InvalidArgumentException Is thrown if the finder with the passed key is not available
     */
    public function getFinder($key)
    {

        // query whether or not the finder is available
        if (isset($this->finders[$key])) {
            return $this->finders[$key];
        }

        // throw an exception, if not
        throw new \InvalidArgumentException(sprintf('Finder "%s" has not been registered', $key));
    }
}
