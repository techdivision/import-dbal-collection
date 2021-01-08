<?php

/**
 * TechDivision\Import\Dbal\Actions\GenericEventAwareAction
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
use TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface;

/**
 * An generic action implementation that extends CRUD functionality with event handling.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class GenericEventAwareAction implements ActionInterface, ProcessorAwareActionInterface, PrimaryKeyAwareActionInterface
{

    /**
     * The action that has to be cached.
     *
     * @var \TechDivision\Import\Dbal\Actions\ActionInterface
     */
    protected $action;

    /**
     * The event emitter instance.
     *
     * @var \League\Event\EmitterInterface
     */
    protected $emitter;

    /**
     * Initialize the array with the default statement names.
     *
     * @var array
     */
    protected $defaultStatementNames = array(
        EntityStatus::STATUS_CREATE => null,
        EntityStatus::STATUS_UPDATE => null,
        EntityStatus::STATUS_DELETE => null
    );

    /**
     * Initializes the action with the passed instances.
     *
     * @param \League\Event\EmitterInterface                    $emitter The event emitter instance
     * @param \TechDivision\Import\Dbal\Actions\ActionInterface $action  The action that has to be cached
     */
    public function __construct(EmitterInterface $emitter, ActionInterface $action)
    {

        // set emitter and action instance
        $this->action = $action;
        $this->emitter = $emitter;

        // try to load the default statement names from the processor instances
        if ($action->getCreateProcessor() instanceof ProcessorInterface) {
            $this->defaultStatementNames[EntityStatus::STATUS_CREATE] = $action->getCreateProcessor()->getDefaultStatementName();
        }

        if ($action->getUpdateProcessor() instanceof ProcessorInterface) {
            $this->defaultStatementNames[EntityStatus::STATUS_UPDATE] = $action->getUpdateProcessor()->getDefaultStatementName();
        }

        if ($action->getDeleteProcessor() instanceof ProcessorInterface) {
            $this->defaultStatementNames[EntityStatus::STATUS_DELETE] = $action->getDeleteProcessor()->getDefaultStatementName();
        }
    }

    /**
     * Return's the primary key of the entity to persist.
     *
     * @return string The primary key name
     */
    public function getPrimaryKeyMemberName()
    {
        return $this->action->getPrimaryKeyMemberName();
    }

    /**
     * Return's the create processor instance.
     *
     * @return \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface The create processor instance
     */
    public function getCreateProcessor()
    {
        return $this->action->getCreateProcessor();
    }

    /**
     * Return's the delete processor instance.
     *
     * @return \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface The delete processor instance
     */
    public function getDeleteProcessor()
    {
        return $this->action->getDeleteProcessor();
    }

    /**
     * Return's the update processor instance.
     *
     * @return \TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface The update processor instance
     */
    public function getUpdateProcessor()
    {
        return $this->action->getUpdateProcessor();
    }

    /**
     * Delete's the entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function delete(array $row, $name = null)
    {

        try {
            $this->emit(EventNames::ACTION_DELETE_START, $row);
            $this->action->delete($row, $name);
            $this->emit(EventNames::ACTION_DELETE_SUCCES, $row);
        } catch (\Exception $e) {
            $this->emit(EventNames::ACTION_DELETE_FAILURE, $row);
            throw $e;
        }
    }

    /**
     * Helper method that create/update the passed entity, depending on
     * the entity's status.
     *
     * @param array       $row  The entity data to create/update
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persist(array $row, $name = null)
    {

        try {
            $this->emit(EventNames::ACTION_PERSIST_START, $row);
            call_user_func(array($this, $row[EntityStatus::MEMBER_NAME]), $row, $name);
            $this->emit(EventNames::ACTION_PERSIST_SUCCES, $row);
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
     * @return void
     */
    public function create(array $row, $name = null)
    {

        try {
            $this->emit(EventNames::ACTION_CREATE_START, $row);
            $this->action->create($row, $name);
            $this->emit(EventNames::ACTION_CREATE_SUCCES, $row);
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
     * @return void
     */
    public function update(array $row, $name = null)
    {

        try {
            $this->emit(EventNames::ACTION_UPDATE_START, $row);
            $this->action->update($row, $name);
            $this->emit(EventNames::ACTION_UPDATE_SUCCES, $row);
        } catch (\Exception $e) {
            $this->emit(EventNames::ACTION_UPDATE_FAILURE, $row);
            throw $e;
        }
    }

    /**
     * Return's the default statement name from the action.
     *
     * @param array $row The row with the entity status
     *
     * @return string|null The default statement name
     */
    protected function getDefaultStatementName(array $row)
    {
        return $this->defaultStatementNames[isset($row[EntityStatus::MEMBER_NAME]) ? $row[EntityStatus::MEMBER_NAME] : EntityStatus::STATUS_DELETE];
    }

    /**
     * Emit's the events of the passed event name.
     *
     * @param string       $eventName The event name to trigger the events for
     * @param array        $row       The row with the entity data that'll be passed to the listeners handle() method
     * @param integer|null $id        The ID of the created/updated entity that'll be passed to the listeners handle() method
     *
     * @return void
     */
    protected function emit($eventName, array $row, $id = null)
    {

        // event the default event
        $this->emitter->emit($eventName, $this, $row, $id);

        // try to load the default statement name
        $defaultStatementName = $this->getDefaultStatementName($row);

        // trigger the event with default statement name, if available
        if ($defaultStatementName !== null) {
            $this->emitter->emit(sprintf('%s.%s', $eventName, $defaultStatementName), $this, $row, $id);
        }
    }
}
