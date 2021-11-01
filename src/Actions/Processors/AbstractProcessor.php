<?php

/**
 * TechDivision\Import\Dbal\Actions\Processors\AbstractProcessor
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Actions\Processors;

use TechDivision\Import\Dbal\Connection\ConnectionInterface;
use TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface;
use TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface;

/**
 * An abstract CRUD processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
abstract class AbstractProcessor implements ProcessorInterface
{

    /**
     * The connection instance.
     * .
     * @var \TechDivision\Import\Dbal\Connection\ConnectionInterface;
     */
    protected $connection;

    /**
     * The respository instance with the SQL statements to use.
     *
     * @var \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface
     */
    protected $sqlStatementRepository;

    /**
     * Initialize the processor with the passed connection and utility class name.
     * .
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface               $connection             The connection instance
     * @param \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface $sqlStatementRepository The repository instance
     */
    public function __construct(
        ConnectionInterface $connection,
        SqlStatementRepositoryInterface $sqlStatementRepository
    ) {

        // set the passed instances
        $this->setConnection($connection);
        $this->setSqlStatementRepository($sqlStatementRepository);

        // initialize the instance
        $this->init();
    }

    /**
     * Set's the connection to use.
     * .
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface $connection The connection instance
     *
     * @return void
     */
    public function setConnection(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return's the connection to use.
     *
     * @return \TechDivision\Import\Dbal\Connection\ConnectionInterface The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Set's the repository instance with the SQL statements to use.
     *
     * @param \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface $sqlStatementRepository The repository instance
     *
     * @return void
     */
    public function setSqlStatementRepository(SqlStatementRepositoryInterface $sqlStatementRepository)
    {
        $this->sqlStatementRepository = $sqlStatementRepository;
    }

    /**
     * Return's the repository instance with the SQL statements to use.
     *
     * @return \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface The repository instance
     */
    public function getSqlStatementRepository()
    {
        return $this->sqlStatementRepository;
    }

    /**
     * Return's the class name of the SQL repository instance with the SQL statements to use.
     *
     * @return string The SQL repository instance class name
     */
    public function getSqlStatementRepositoryClassName()
    {
        return get_class($this->getSqlStatementRepository());
    }

    /**
     * Load's the SQL statement with the passed ID from the SQL repository.
     *
     * @param string $id The ID of the SQL statement to load
     *
     * @return string The SQL statement with the passed ID
     */
    public function loadStatement($id)
    {
        return $this->getSqlStatementRepository()->load($id);
    }
}
