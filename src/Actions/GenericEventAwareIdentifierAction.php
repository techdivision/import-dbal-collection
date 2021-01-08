<?php

/**
 * TechDivision\Import\Dbal\Actions\GenericEventAwareIdentifierAction
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

namespace TechDivision\Import\Dbal\Actions;

use League\Event\EmitterInterface;
use TechDivision\Import\Dbal\Utils\EventNames;
use TechDivision\Import\Dbal\Utils\EntityStatus;

/**
 * An generic identifier action implementation that extends CRUD functionality with event handling.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class GenericEventAwareIdentifierAction extends GenericEventAwareAction implements IdentifierActionInterface
{

    /**
     * The action that has to be cached.
     *
     * @var \TechDivision\Import\Dbal\Actions\IdentifierActionInterface
     */
    protected $action;

    /**
     * Initializes the action with the passed instances.
     *
     * @param \League\Event\EmitterInterface                              $emitter The event emitter instance
     * @param \TechDivision\Import\Dbal\Actions\IdentifierActionInterface $action  The action that has to be cached
     */
    public function __construct(EmitterInterface $emitter, IdentifierActionInterface $action)
    {
        parent::__construct($emitter, $action);
    }

    /**
     * Helper method that create/update the passed entity, depending on
     * the entity's status.
     *
     * @param array       $row  The entity data to create/update
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persist(array $row, $name = null)
    {
        try {
            $this->emit(EventNames::ACTION_PERSIST_START, $row);
            $id = call_user_func(array($this, $row[EntityStatus::MEMBER_NAME]), $row, $name);
            $this->emit(EventNames::ACTION_PERSIST_SUCCES, $row, $id);
            return $id;
        } catch (\Exception $e) {
            $this->emit(EventNames::ACTION_PERSIST_FAILURE, $row);
            throw $e;
        }
    }

    /**
     * Creates's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to create
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The ID of the created entity
     */
    public function create(array $row, $name = null)
    {
        try {
            $this->emit(EventNames::ACTION_CREATE_START, $row);
            $id = $this->action->create($row, $name);
            $this->emit(EventNames::ACTION_CREATE_SUCCES, $row, $id);
            return $id;
        } catch (\Exception $e) {
            $this->emit(EventNames::ACTION_CREATE_FAILURE, $row);
            throw $e;
        }
    }

    /**
     * Update's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to update
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return string The ID of the updated entity
     */
    public function update(array $row, $name = null)
    {
        try {
            $this->emit(EventNames::ACTION_UPDATE_START, $row);
            $id = $this->action->update($row, $name);
            $this->emit(EventNames::ACTION_UPDATE_SUCCES, $row, $id);
            return $id;
        } catch (\Exception $e) {
            $this->emit(EventNames::ACTION_UPDATE_FAILURE, $row);
            throw $e;
        }
    }
}
