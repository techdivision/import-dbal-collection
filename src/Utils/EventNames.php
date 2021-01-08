<?php

/**
 * TechDivision\Import\Dbal\Utils\EventNames
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

namespace TechDivision\Import\Dbal\Utils;

/**
 * A utility class with the available event names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-dbal
 * @link      http://www.techdivision.com
 */
class EventNames
{

    /**
     * This is a utility class, so protect it against direct
     * instantiation.
     */
    private function __construct()
    {
    }

    /**
     * This is a utility class, so protect it against cloning.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * The event name for the event that'll be invoked before an actions delete() functionality will be processed.
     *
     * @var string
     */
    const ACTION_DELETE_START = 'action.delete.start';

    /**
     * The event name for the event that'll be invoked after an actions delete() functionality has been processed successfully.
     *
     * @var string
     */
    const ACTION_DELETE_SUCCES = 'action.delete.success';

    /**
     * The event name for the event that'll be invoked when an actions delete() functionality failed.
     *
     * @var string
     */
    const ACTION_DELETE_FAILURE = 'action.delete.failure';

    /**
     * The event name for the event that'll be invoked before an actions persist() functionality will be processed.
     *
     * @var string
     */
    const ACTION_PERSIST_START = 'action.persist.start';

    /**
     * The event name for the event that'll be invoked after an actions persist() functionality has been processed successfully.
     *
     * @var string
     */
    const ACTION_PERSIST_SUCCES = 'action.persist.success';

    /**
     * The event name for the event that'll be invoked when an actions persist() functionality failed.
     *
     * @var string
     */
    const ACTION_PERSIST_FAILURE = 'action.persist.failure';

    /**
     * The event name for the event that'll be invoked before an actions create() functionality will be processed.
     *
     * @var string
     */
    const ACTION_CREATE_START = 'action.create.start';

    /**
     * The event name for the event that'll be invoked after an actions create() functionality has been processed successfully.
     *
     * @var string
     */
    const ACTION_CREATE_SUCCES = 'action.create.success';

    /**
     * The event name for the event that'll be invoked when an actions create() functionality failed.
     *
     * @var string
     */
    const ACTION_CREATE_FAILURE = 'action.create.failure';

    /**
     * The event name for the event that'll be invoked before an actions update() functionality will be processed.
     *
     * @var string
     */
    const ACTION_UPDATE_START = 'action.update.start';

    /**
     * The event name for the event that'll be invoked after an actions update() functionality has been processed successfully.
     *
     * @var string
     */
    const ACTION_UPDATE_SUCCES = 'action.update.success';

    /**
     * The event name for the event that'll be invoked when an actions update() functionality failed.
     *
     * @var string
     */
    const ACTION_UPDATE_FAILURE = 'action.update.failure';
}
