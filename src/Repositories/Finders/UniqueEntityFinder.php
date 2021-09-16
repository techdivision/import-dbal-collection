<?php

/**
 * TechDivision\Import\Dbal\Repositories\Finders\UniqueEntityFinder
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

use TechDivision\Import\Dbal\Repositories\Finders\EntityFinderInterface;

/**
 * A unqiue entity finder implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class UniqueEntityFinder extends UniqueFinder implements EntityFinderInterface
{

    /**
     * The finder's unique key name.
     *
     * @var string
     */
    protected $uniqueKeyName;

    /**
     * Initialize the repository with the passed connection and utility class name.
     * .
     * @param \PDOStatement $preparedStatement The prepared statement
     * @param string        $key               The unqiue key of the prepared statement that has to be executed.
     * @param string        $primaryKeyName    The entity's primary key
     * @param string        $entityName        The finder's entity name
     * @param string        $uniqueKeyName     The finder's unique key name
     */
    public function __construct(\PDOStatement $preparedStatement, $key, $primaryKeyName, $entityName, $uniqueKeyName)
    {

        // invoke the parent method
        parent::__construct($preparedStatement, $key, $primaryKeyName, $entityName);

        // set the finder's unique key name
        $this->uniqueKeyName = $uniqueKeyName;
    }

    /**
     * Return's the entity's primary key name.
     *
     * @return string The entity's primary key name
     */
    public function getPrimaryKeyName()
    {
        return $this->getUniqueKeyName();
    }

    /**
     * Return's the entity unique key name.
     *
     * @return string The name of the entity's unique key
     */
    public function getUniqueKeyName()
    {
        return $this->uniqueKeyName;
    }
}
