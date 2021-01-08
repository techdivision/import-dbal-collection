<?php

/**
 * TechDivision\Import\Dbal\Actions\Processors\GenericProcessor
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
 * A processor implementation providing black hole functionality, which means
 * that it will not do anything.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class GenericProcessor extends AbstractBaseProcessor
{

    /**
     * The array with the statement keys.
     *
     * @var array
     */
    protected $statementKeys = array();

    /**
     * Initialize the processor with the passed connection and utility class name, as well as optional sanitizers.
     * .
     * @param \TechDivision\Import\Dbal\Connection\ConnectionInterface               $connection             The connection instance
     * @param \TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface $sqlStatementRepository The repository instance
     * @param \ArrayObject                                                           $sanitizers             The array with the sanitizer instances
     * @param array                                                                  $statementKeys          The array with the statment keys
     */
    public function __construct(
        ConnectionInterface $connection,
        SqlStatementRepositoryInterface $sqlStatementRepository,
        \ArrayObject $sanitizers = null,
        array $statementKeys = array()
    ) {

        // set the list with the SQL statement keys
        $this->setStatementKeys($statementKeys);

        // pass the connection and the SQL statement repository to the parent class
        parent::__construct($connection, $sqlStatementRepository, $sanitizers);
    }

    /**
     * Return's the array with the SQL statements that has to be prepared.
     *
     * @return array The SQL statements to be prepared
     */
    protected function getStatements()
    {

        // iterate over the SQL statement keys and
        // initialize the prepared statements
        foreach ($this->statementKeys as $statementKey) {
            $this->statements[$statementKey] = $this->loadStatement($statementKey);
        }

        // return the array with the prepared statements
        return $this->statements;
    }

    /**
     * Gets the list with the SQL statement keys.
     *
     * @return array The SQL statement keys
     */
    protected function getStatementKeys(): array
    {
        return $this->statementKeys;
    }

    /**
     * Sets list with the SQL statement keys.
     *
     * @param array $statementKeys The SQL statement keys
     *
     * @return void
     */
    protected function setStatementKeys(array $statementKeys): void
    {
        $this->statementKeys = $statementKeys;
    }
}
