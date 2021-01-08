<?php

/**
 * TechDivision\Import\Dbal\Actions\Processors\GenericProcessorWrapper
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

namespace TechDivision\Import\Dbal\Actions\Processors;

use TechDivision\Import\Dbal\Connection\ConnectionInterface;
use TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface;

/**
 * A processor implementation that simply wraps another processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class GenericProcessorWrapper implements ProcessorInterface
{

    /**
     * The processor instance.
     *
     * @var \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface
     */
    private $processor;

    /**
     * Initializes the black hole processor with the processor instance it should black whole.
     *
     * @param \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface $processor The processor instance that has to be black holed
     */
    public function __construct(ProcessorInterface $processor)
    {
        $this->processor = $processor;
    }

    /**
     * Set's the connection to use.
     * .
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface $connection The connection instance
     *
     * @return void
     */
    public function setConnection(ConnectionInterface $connection) : void
    {
        $this->processor->setConnection($connection);
    }

    /**
     * Return's the connection to use.
     *
     * @return \TechDivision\Import\Dbal\Connection\ConnectionInterface The connection instance
     */
    public function getConnection() : ConnectionInterface
    {
        return $this->processor->getConnection();
    }

    /**
     * Set's the repository instance with the SQL statements to use.
     *
     * @param \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface $sqlStatementRepository The repository instance
     *
     * @return void
     */
    public function setSqlStatementRepository(SqlStatementRepositoryInterface $sqlStatementRepository) : void
    {
        $this->processor->setSqlStatementRepository($sqlStatementRepository);
    }

    /**
     * Return's the repository instance with the SQL statements to use.
     *
     * @return \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface The repository instance
     */
    public function getSqlStatementRepository() : SqlStatementRepositoryInterface
    {
        return $this->processor->getSqlStatementRepository();
    }

    /**
     * Return's the class name of the SQL repository instance with the SQL statements to use.
     *
     * @return string The SQL repository instance class name
     */
    public function getSqlStatementRepositoryClassName() : string
    {
        return $this->processor->getSqlStatementRepositoryClassName();
    }

    /**
     * Load's the SQL statement with the passed ID from the SQL repository.
     *
     * @param string $id The ID of the SQL statement to load
     *
     * @return string The SQL statement with the passed ID
     */
    public function loadStatement($id) : string
    {
        return $this->processor->loadStatement($id);
    }

    /**
     * Gets sanitizers list.
     *
     * @return \ArrayObject The sanitizers
     */
    public function getSanitizers(): \ArrayObject
    {
        return $this->processor->getSanitizers();
    }

    /**
     * Sets sanitizers list.
     *
     * @param \ArrayObject $sanitizers The sanitizers
     *
     * @return void
     */
    public function setSanitizers(\ArrayObject $sanitizers): void
    {
        $this->processor->setSanitizers($sanitizers);
    }

    /**
     * Return's the name of the processor's default statement.
     *
     * @return string The statement name
     */
    public function getDefaultStatementName() : string
    {
        return $this->processor->getDefaultStatementName();
    }

    /**
     * Initializes the proceessor with the prepared statements.
     *
     * @return void
     */
    public function init() : void
    {
        $this->processor->init();
    }

    /**
     * Implements the CRUD functionality the processor is responsible for,
     * can be one of CREATE, READ, UPDATE or DELETE a entity.
     *
     * @param array       $row                  The row to persist
     * @param string|null $name                 The name of the prepared statement that has to be executed
     * @param string|null $primaryKeyMemberName The primary key member name of the entity to use
     *
     * @return integer|null Either the exisiting or a new ID of the persisted entity
     */
    public function execute($row, $name = null, $primaryKeyMemberName = null)
    {
        return $this->execute($row, $name, $primaryKeyMemberName);
    }
}
