<?php

/**
 * TechDivision\Import\Dbal\Collection\Connection\ConnectionFactory
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Connection;

use TechDivision\Import\Dbal\Configuration\ConfigurationInterface;

/**
 * The connection factory implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class ConnectionFactory
{

    /**
     * Create's and return's the connection to use.
     *
     * @param \TechDivision\Import\Dbal\Configuration\ConfigurationInterface $configuration The configuration with the data to create the connection with
     *
     * @return \TechDivision\Import\Dbal\Collection\Connection\PDOConnectionWrapper The initialized connection
     */
    public static function createConnection(ConfigurationInterface $configuration)
    {

        // initialize the PDO connection
        $dsn = $configuration->getDatabase()->getDsn();
        $username = $configuration->getDatabase()->getUsername();
        $password = $configuration->getDatabase()->getPassword();
        $connection = new \PDO($dsn, $username, $password);
        $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        /* As of MySQL version > 5.7.4 the ONLY_FULL_GROUP_BY is activated by default. So in some */
        /* cases it is necessary to activate to TRADITIONAL mode to allow certain queries to run, */
        /* https://dev.mysql.com/doc/refman/5.7/en/sql-mode.html#sqlmode_only_full_group_by       */
        $connection->exec('SET SESSION sql_mode = traditional');

        // reurn the wrapped PDO connection
        return new PDOConnectionWrapper($connection);
    }
}
