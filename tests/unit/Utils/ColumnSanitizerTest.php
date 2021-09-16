<?php

/**
* TechDivision\Import\Collection\Dbal\Collection\Utils\ColumnSanitizerTest
 *
 * PHP version 7
 *
 * @author    Team CSI <csi-kolbermoor@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Dbal\Collection\Utils;

use PHPUnit\Framework\TestCase;

/**
 * Test class for the column sanitizer utility.
 *
 * @author    Team CSI <csi-kolbermoor@techdivision.com>
 * @copyright 2020 TechDivision GmbH <info@techdivision.com>
 * @license   https://opensource.org/licenses/MIT
 * @link      https://github.com/techdivision/import-dbal-collection
 * @link      http://www.techdivision.com
 */
class ColumnSanitizerTest extends TestCase
{

    /**
     * The utility we want to test.
     *
     * @var \TechDivision\Import\Dbal\\Utils\SanitizerInterface
     */
    protected $columnSanitizer;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     * @see \PHPUnit\Framework\TestCase::setUp()
     */
    protected function setUp()
    {
        // initialize the utility we want to test
        $this->columnSanitizer = new ColumnSanitizer();
    }

    public function testExecuteGivenEmptyRowReturnsEmptyRow()
    {
        $query = 'UPDATE some_table SET column_1=:column_1, column_2=:column_2 WHERE condition=:value';
        $row = [];
        $expected = [];

        $actual = $this->columnSanitizer->execute($row, $query);

        $this->assertEquals($expected, $actual);
    }

    public function testExecuteGivenEmptyStatementReturnsEmptyRow()
    {
        $query = '';
        $row = ['column_1' => 'foo', 'value' => 'bar'];
        $expected = [];

        $actual = $this->columnSanitizer->execute($row, $query);

        $this->assertEquals($expected, $actual);
    }

    public function testExecuteGivenLessColumnsThanAllowedReturnsOnlyAllowedGivenColumns()
    {
        $query = 'UPDATE some_table SET column_1=:column_1, column_2=:column_2 WHERE condition=:value';
        $row = ['column_1' => 'foo', 'value' => 'bar'];
        $expected = ['column_1' => 'foo', 'value' => 'bar'];

        $actual = $this->columnSanitizer->execute($row, $query);

        $this->assertEquals($expected, $actual);
    }

    public function testExecuteGivenAllAllowedColumnsReturnsAllColumns()
    {
        $query = 'UPDATE some_table SET column_1=:column_1, column_2=:column_2 WHERE condition=:value';
        $row = ['column_1' => 'foo', 'column_2' => 'baz', 'value' => 'bar'];
        $expected = ['column_1' => 'foo', 'column_2' => 'baz', 'value' => 'bar'];

        $actual = $this->columnSanitizer->execute($row, $query);

        $this->assertEquals($expected, $actual);
    }

    public function testExecuteGivenMoreThanAllowedColumnsReturnsOnlAllowedColumns()
    {
        $query = 'UPDATE some_table SET column_1=:column_1, column_2=:column_2 WHERE condition=:value';
        $row = ['column_1' => 'foo', 'column_2' => 'baz', 'value' => 'bar', 'additional' => 'another value'];
        $expected = ['column_1' => 'foo', 'column_2' => 'baz', 'value' => 'bar'];

        $actual = $this->columnSanitizer->execute($row, $query);

        $this->assertEquals($expected, $actual);
    }

    public function testExecuteGivenSpecialColumnReturnsDataIncludingSpecialColumn()
    {
        $query = 'UPDATE some_table SET column_1=:column_1, column_2=:column_2 WHERE condition=:value';
        $row = [
            'column_1' => 'foo',
            'column_2' => 'baz',
            'value' => 'bar',
            'techdivision_import_utils_entityStatus_memberName' => 'update',
        ];
        $expected = [
            'column_1' => 'foo',
            'column_2' => 'baz',
            'value' => 'bar',
            'techdivision_import_utils_entityStatus_memberName' => 'update',
        ];

        $actual = $this->columnSanitizer->execute($row, $query);

        $this->assertEquals($expected, $actual);
    }
}
