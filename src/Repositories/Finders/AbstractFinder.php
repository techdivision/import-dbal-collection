<?php

/**
 * TechDivision\Import\Dbal\Repositories\Finders\AbstractFinder
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Repositories\Finders;

use TechDivision\Import\Dbal\Repositories\Finders\FinderInterface;

/**
 * An abstract finder implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
abstract class AbstractFinder implements FinderInterface
{

    /**
     * The unique key of the prepared statement that has to be executed.
     *
     * @var string
     */
    protected $key;

    /**
     * The entity's primary key name.
     *
     * @var string
     */
    protected $primaryKeyName;

    /**
     * The finder's entity name.
     *
     * @var string
     */
    protected $entityName;

    /**
     * The prepared statement.
     *
     * @var \PDOStatement
     */
    protected $preparedStatement;

    /**
     * Initialize the repository with the passed connection and utility class name.
     * .
     * @param \PDOStatement $preparedStatement The prepared statement
     * @param string        $key               The unqiue key of the prepared statement that has to be executed.
     * @param string        $primaryKeyName    The entity's primary key
     * @param string        $entityName        The finder's entity name
     */
    public function __construct(\PDOStatement $preparedStatement, $key, $primaryKeyName, $entityName)
    {
        $this->preparedStatement = $preparedStatement;
        $this->primaryKeyName = $primaryKeyName;
        $this->entityName = $entityName;
        $this->key = $key;
    }

    /**
     * Return's the finder's unique key.
     *
     * @return string The unique key
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Return's the entity's primary key name.
     *
     * @return string The entity's primary key name
     */
    public function getPrimaryKeyName()
    {
        return $this->primaryKeyName;
    }

    /**
     * Return's the finder's entity name.
     *
     * @return string The finder's entity name
     */
    public function getEntityName()
    {
        return $this->entityName;
    }
}
