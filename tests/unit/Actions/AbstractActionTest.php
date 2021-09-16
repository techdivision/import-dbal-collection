<?php

/**
 * TechDivision\Import\Dbal\Collection\Actions\AbstractAction
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

use PHPUnit\Framework\TestCase;
use TechDivision\Import\Dbal\Actions\Processors\ProcessorInterface;

/**
 * Test class for the abstract action implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2021 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class AbstractActionTest extends TestCase
{

    /**
     * Test's the getter/setter for the create processor.
     *
     * @return void
     */
    public function testSetGetCreateProcessor()
    {

        // create a persist processor mock instance
        $mockCreateProcessor = $this->getMockBuilder($processorInterface = ProcessorInterface::class)
                                    ->setMethods(get_class_methods($processorInterface))
                                    ->getMock();

        // create a mock for the abstract action
        $mockAction = $this->getMockForAbstractClass(AbstractAction::class);

        // test the setter/getter for the persist processor
        $mockAction->setCreateProcessor($mockCreateProcessor);
        $this->assertSame($mockCreateProcessor, $mockAction->getCreateProcessor());
    }

    /**
     * Test's the getter/setter for the delete processor.
     *
     * @return void
     */
    public function testSetGetDeleteProcessor()
    {

        // create a delete processor mock instance
        $mockDeleteProcessor = $this->getMockBuilder($processorInterface = ProcessorInterface::class)
                                    ->setMethods(get_class_methods($processorInterface))
                                    ->getMock();

        // create a mock for the abstract action
        $mockAction = $this->getMockForAbstractClass(AbstractAction::class);

        // test the setter/getter for the delete processor
        $mockAction->setDeleteProcessor($mockDeleteProcessor);
        $this->assertSame($mockDeleteProcessor, $mockAction->getDeleteProcessor());
    }

    /**
     * Test's the persist() method successfull.
     *
     * @return void
     */
    public function testCreateWithSuccess()
    {

        // create a create processor mock instance
        $mockCreateProcessor = $this->getMockBuilder($processorInterface = ProcessorInterface::class)
                                    ->setMethods(get_class_methods($processorInterface))
                                    ->getMock();
        $mockCreateProcessor->expects($this->once())
                            ->method('execute')
                            ->with($row = array())
                            ->willReturn(null);

        // create a mock for the abstract action
        $mockAction = $this->getMockBuilder(AbstractAction::class)
                           ->setMethods(array('getCreateProcessor'))
                           ->getMock();
        $mockAction->expects($this->once())
                   ->method('getCreateProcessor')
                   ->willReturn($mockCreateProcessor);

        // test the persist() method
        $this->assertNull($mockAction->create($row));
    }

    /**
     * Test's the delete() method successfull.
     *
     * @return void
     */
    public function testDeleteWithSuccess()
    {

        // create a delete processor mock instance
        $mockDeleteProcessor = $this->getMockBuilder($processorInterface = ProcessorInterface::class)
                                    ->setMethods(get_class_methods($processorInterface))
                                    ->getMock();
        $mockDeleteProcessor->expects($this->once())
                            ->method('execute')
                            ->with($row = array())
                            ->willReturn(null);

        // create a mock for the abstract action
        $mockAction = $this->getMockBuilder(AbstractAction::class)
                           ->setMethods(array('getDeleteProcessor'))
                           ->getMock();
        $mockAction->expects($this->once())
                   ->method('getDeleteProcessor')
                   ->willReturn($mockDeleteProcessor);

        // test the delete() method
        $this->assertNull($mockAction->delete($row));
    }
}
