<?php

/**
 * TechDivision\Import\Dbal\Actions\GenericDynamicIdentifierAction
 *
 * PHP version 7
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Actions;

use TechDivision\Import\Dbal\Utils\PrimaryKeyUtilInterface;
use TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface;

/**
 * An action implementation that provides CRUD functionality and returns the ID of
 * the persisted entity for the `update` and `create` methods.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class GenericDynamicIdentifierAction extends GenericIdentifierAction
{

    /**
     * Initialize the instance with the passed processors.
     *
     * @param \TechDivision\Import\Dbal\Utils\PrimaryKeyUtilInterface              $primaryKeyUtil  The primary key utility instance
     * @param \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface|null $createProcessor The create processor instance
     * @param \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface|null $updateProcessor The update processor instance
     * @param \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface|null $deleteProcessor The delete processor instance
     */
    public function __construct(
        PrimaryKeyUtilInterface $primaryKeyUtil,
        ProcessorInterface $createProcessor = null,
        ProcessorInterface $updateProcessor = null,
        ProcessorInterface $deleteProcessor = null
    ) {

        // pass the processor instances and the primary key name to the parent constructor
        parent::__construct($createProcessor, $updateProcessor, $deleteProcessor, $primaryKeyUtil->getPrimaryKeyMemberName());
    }
}
