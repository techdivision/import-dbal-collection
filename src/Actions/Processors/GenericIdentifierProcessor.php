<?php

/**
 * TechDivision\Import\Dbal\Actions\Processors\GenericIdentifierProcessor
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

/**
 * A processor implementation providing black hole functionality, which means
 * that it will not do anything.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class GenericIdentifierProcessor extends GenericProcessor
{

    /**
     * Update's the passed row.
     *
     * @param array       $row                  The row to persist
     * @param string|null $name                 The name of the prepared statement that has to be executed
     * @param string|null $primaryKeyMemberName The primary key member name of the entity to use
     *
     * @return string The ID of the updated entity
     */
    public function execute($row, $name = null, $primaryKeyMemberName = null)
    {

        // invoke the parent method and
        // xecute the prepared statement
        parent::execute($row, $name);

        // return the member with the passed name or the last inserted ID
        return $row[$primaryKeyMemberName] ?? $this->getConnection()->lastInsertId();
    }
}
