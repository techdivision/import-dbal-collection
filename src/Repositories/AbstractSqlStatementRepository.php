<?php

/**
 * TechDivision\Import\Dbal\Repositories\AbstractSqlStatementRepository
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

use TechDivision\Import\Dbal\Repositories\SqlStatementRepositoryInterface;

/**
 * Abstract repository class for the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
abstract class AbstractSqlStatementRepository implements SqlStatementRepositoryInterface
{

    /**
     * The initializes SQL statements.
     *
     * @var array
     */
    private $preparedStatements = array();

    /**
     * The array with the compiler instances.
     *
     * @var \IteratorAggregate<\TechDivision\Import\Dbal\Utils\SqlCompilerInterface>
     */
    private $compilers = array();

    /**
     * Initializes the SQL statement repository with the primary key and table prefix utility.
     *
     * @param \IteratorAggregate<\TechDivision\Import\Dbal\Utils\SqlCompilerInterface> $compilers The array with the compiler instances
     */
    public function __construct(\IteratorAggregate $compilers)
    {
        $this->compilers = $compilers;
    }

    /**
     * Returns the SQL statement with the passed ID.
     *
     * @param string $id The ID of the SQL statement to return
     *
     * @return string The SQL statement
     * @throws \Exception Is thrown, if the SQL statement with the passed key cannot be found
     */
    public function load($id)
    {

        // try to find the SQL statement with the passed key
        if (isset($this->preparedStatements[$id])) {
            return $this->preparedStatements[$id];
        }

        // throw an exception if NOT available
        throw new \Exception(sprintf('Can\'t find SQL statement with ID %s', $id));
    }

    /**
     * Compiles the passed SQL statements.
     *
     * @param array $statements The SQL statements to compile
     *
     * @return void
     */
    protected function compile(array $statements)
    {

        // iterate over all statements and compile them
        foreach ($statements as $key => $statement) {
            // compile the statement
            foreach ($this->compilers as $compiler) {
                $statement = $compiler->compile($statement);
            }
            // add the comiled statemnent to the list
            $this->preparedStatements[$key] = $statement;
        }
    }
}
