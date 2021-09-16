<?php

/**
 * TechDivision\Import\Dbal\Repositories\Finders\YieldedFinder
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

/**
 * Yielded finder implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class YieldedFinder extends SimpleFinder
{

    /**
     * Executes the finder with the passed parameters.
     *
     * @param array $params The finder params
     *
     * @return array The finder result
     */
    public function find(array $params = array())
    {

        // execute the prepared statement
        $this->preparedStatement->execute($params);

        // fetch the values and return them
        while ($record = $this->preparedStatement->fetch(\PDO::FETCH_ASSOC)) {
            // return the record
            yield $record;
        }
    }
}
