<?php
/**
 * This file is part of OXID eShop Community Edition.
 *
 * OXID eShop Community Edition is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID eShop Community Edition is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID eShop Community Edition.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version   OXID eShop CE
 */

namespace OxidEsales\EshopCommunity\Tests\Integration\Core\Database\Adapter\Doctrine;

use PDO;
use Doctrine\DBAL\DBALException;
use OxidEsales\EshopCommunity\Core\Exception\DatabaseException;
use OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\ResultSet;
use OxidEsales\EshopCommunity\Core\Database\Adapter\DatabaseInterface;
use OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database;
use OxidEsales\EshopCommunity\Tests\Integration\Core\Database\Adapter\DatabaseInterfaceImplementationTest;

/**
 * Tests for our database object.
 *
 * @group database-adapter
 */
class DatabaseTest extends DatabaseInterfaceImplementationTest
{
    /**
     * @var string The database exception class to be thrown
     */
    const DATABASE_EXCEPTION_CLASS = DatabaseException::class;

    /**
     * @var string The result set class class
     */
    const RESULT_SET_CLASS = ResultSet::class;

    /**
     * @var DatabaseInterface|Database The database to test.
     */
    protected $database = null;

    /**
     * Create the database object under test.
     *
     * @return Database The database object under test.
     */
    protected function createDatabase()
    {
        return \oxDb::getDb();
    }

    /**
     * Close the database connection.
     */
    protected function closeConnection()
    {
        $this->database->closeConnection();
    }

    /**
     * @return string The name of the database exception class
     */
    protected function getDatabaseExceptionClassName()
    {
        return self::DATABASE_EXCEPTION_CLASS;
    }

    /**
     * @return string The name of the result set class
     */
    protected function getResultSetClassName()
    {
        return self::RESULT_SET_CLASS;
    }

    /**
     * Test that the expected exception is thrown for an invalid function parameter.
     * See the data provider for arguments considered invalid.
     *
     * @dataProvider dataProviderTestGetAllThrowsDatabaseExceptionOnInvalidArguments
     *
     * @param mixed $invalidParameter A parameter, which is considered invalid and will trigger an exception
     */
    public function testGetAllThrowsDatabaseExceptionOnInvalidArguments($invalidParameter)
    {
        $expectedExceptionClass = '\InvalidArgumentException';
        $this->setExpectedException($expectedExceptionClass);

        $this->database->getAll(
            "SELECT OXID FROM " . self::TABLE_NAME . " WHERE OXID = '" . self::FIXTURE_OXID_1 . "'",
            $invalidParameter
        );
    }

    /**
     * Test, that the method 'selectLimit' returns the expected rows from the database for different
     * values of limit and offset.
     *
     * This test assumes that there are at least 3 entries in the table.
     *
     * @dataProvider dataProviderTestSelectLimitForInvalidOffsetAndLimit
     *
     * @param string $assertionMessage A message explaining the assertion
     * @param int    $rowCount         Maximum number of rows to return
     * @param int    $offset           Offset of the first row to return
     * @param array  $expectedResult   The expected result of the method call.
     */
    public function testSelectLimitForInvalidOffsetAndLimit($assertionMessage, $rowCount, $offset, $expectedResult)
    {
        $this->loadFixtureToTestTable();
        $sql = 'SELECT OXID FROM ' . self::TABLE_NAME . ' WHERE OXID IN (' .
               '"' . self::FIXTURE_OXID_1 . '",' .
               '"' . self::FIXTURE_OXID_2 . '",' .
               '"' . self::FIXTURE_OXID_3 . '"' .
               ')';
        $resultSet = $this->database->selectLimit($sql, $rowCount, $offset);
        $this->assertError(
            E_USER_DEPRECATED,
            'Parameters rowCount and offset have to be numeric in DatabaseInterface::selectLimit(). ' .
            'Please fix your code as this error may trigger an exception in future versions of OXID eShop.'
        );
        $actualResult = $resultSet->fetchAll();

        $this->assertSame($expectedResult, $actualResult, $assertionMessage);
    }

    /**
     * Data provider for testing selectLimit() with invalid parameters
     *
     * @return array
     */
    public function dataProviderTestSelectLimitForInvalidOffsetAndLimit()
    {
        return array(
            array(
                'If parameter rowCount is integer 2 and offset is string " UNION SELECT oxusername FROM oxuser" , a warning will be triggered and the first 2 rows will be returned',
                2, // row count
                " UNION SELECT oxusername FROM oxuser", // offset
                [
                    [self::FIXTURE_OXID_1], [self::FIXTURE_OXID_2]  // expected result
                ]
            ),
            array(
                'If parameter rowCount is integer 2 and offset is string "1  UNION SELECT oxusername FROM oxuser -- " , a warning will be triggered and last 2 rows will be returned',
                2, // row count
                "1  UNION SELECT oxusername FROM oxuser", // offset
                [
                    [self::FIXTURE_OXID_2], [self::FIXTURE_OXID_3]  // expected result
                ]
            ),
            array(
                'If parameter rowCount is string " UNION SELECT oxusername FROM oxuser  --" and offset is 0, a warning will be triggered and the first 2 rows will be returned',
                " UNION SELECT oxusername FROM oxuser  --", // row count
                0, // offset
                []  // expected result
            ),
            array(
                'If parameter rowCount is string "1 UNION SELECT oxusername FROM oxuser  --" and offset is 0, a warning will be triggered and the first 2 rows will be returned',
                "1  UNION SELECT oxusername FROM oxuser --", // row count
                0, // offset
                [
                    [self::FIXTURE_OXID_1]  // expected result
                ]
            ),
        );
    }

    /**
     * Test, that the method 'selectLimit' returns the expected rows from the database for different
     * values of limit and offset.
     *
     * This test assumes that there are at least 3 entries in the table.
     *
     * @param string $assertionMessage A message explaining the assertion
     * @param int    $rowCount         Maximum number of rows to return
     * @param int    $offset           Offset of the first row to return
     * @param array  $expectedResult   The expected result of the method call.
     */
    public function testSelectLimitForOffsetBelowZero()
    {
        $this->loadFixtureToTestTable();
        $sql = 'SELECT OXID FROM ' . self::TABLE_NAME . ' WHERE OXID IN (' .
               '"' . self::FIXTURE_OXID_1 . '",' .
               '"' . self::FIXTURE_OXID_2 . '",' .
               '"' . self::FIXTURE_OXID_3 . '"' .
               ')';

        $this->setExpectedException(\InvalidArgumentException::class, 'Argument $offset must not be smaller than zero.');

        $this->database->selectLimit($sql, 1, -1);
    }

    /**
     * Test, that startTransaction() throws the expected Exception on failure.
     */
    public function testStartTransactionThrowsExpectedExceptionOnFailure()
    {
        $this->setExpectedException(self::DATABASE_EXCEPTION_CLASS);

        $connectionMock =  $this->getMockBuilder('\OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database')
            ->setMethods(['beginTransaction'])
            ->getMock();
        $connectionMock->expects($this->once())
            ->method('beginTransaction')
            ->willThrowException(new DBALException());

        /** @var \OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database|\PHPUnit_Framework_MockObject_MockObject $databaseMock */
        $databaseMock = $this->getMockBuilder('\OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database')
            ->setMethods(['getConnection'])
            ->getMock();
        $databaseMock->expects($this->once())
            ->method('getConnection')
            ->will($this->returnValue($connectionMock));

        $databaseMock->startTransaction();
    }

    /**
     * Test, that commitTransaction() throws the expected Exception on failure.
     */
    public function testCommitTransactionThrowsExpectedExceptionOnFailure()
    {
        $this->setExpectedException(self::DATABASE_EXCEPTION_CLASS);

        $connectionMock =  $this->getMockBuilder('\OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database')
            ->setMethods(['commit'])
            ->getMock();
        $connectionMock->expects($this->once())
            ->method('commit')
            ->willThrowException(new DBALException());

        /** @var \OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database|\PHPUnit_Framework_MockObject_MockObject $databaseMock */
        $databaseMock = $this->getMockBuilder('\OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database')
            ->setMethods(['getConnection'])
            ->getMock();
        $databaseMock->expects($this->once())
            ->method('getConnection')
            ->will($this->returnValue($connectionMock));

        $databaseMock->commitTransaction();
    }

    /**
     * Test, that rollbackTransaction() throws the expected Exception on failure.
     */
    public function testRollbackTransactionThrowsExpectedExceptionOnFailure()
    {
        $this->setExpectedException(self::DATABASE_EXCEPTION_CLASS);

        $connectionMock =  $this->getMockBuilder('\OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database')
            ->setMethods(['rollBack'])
            ->getMock();
        $connectionMock->expects($this->once())
            ->method('rollBack')
            ->willThrowException(new DBALException());

        /** @var \OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database|\PHPUnit_Framework_MockObject_MockObject $databaseMock */
        $databaseMock = $this->getMockBuilder('\OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database')
            ->setMethods(['getConnection'])
            ->getMock();
        $databaseMock->expects($this->once())
            ->method('getConnection')
            ->will($this->returnValue($connectionMock));

        $databaseMock->rollbackTransaction();
    }

    /**
     * Test, that setTransactionIsolationLevel() throws the expected Exception on failure.
     */
    public function testSetTransactionIsolationLevelThrowsExpectedExceptionOnFailure()
    {
        $this->setExpectedException(self::DATABASE_EXCEPTION_CLASS);

        /** @var \OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database|\PHPUnit_Framework_MockObject_MockObject $databaseMock */
        $databaseMock = $this->getMockBuilder('\OxidEsales\EshopCommunity\Core\Database\Adapter\Doctrine\Database')
            ->setMethods(['execute'])
            ->getMock();
        $databaseMock->expects($this->once())
            ->method('execute')
            ->willThrowException(new DBALException());

        $databaseMock->setTransactionIsolationLevel('READ COMMITTED');
    }

    /**
     * Test, that setTransactionIsolationLevel() throws the expected Exception on failure.
     */
    public function testSetTransactionIsolationLevelThrowsExpectedExceptionOnInvalidParameter()
    {
        $this->setExpectedException('\InvalidArgumentException');

        $this->database->setTransactionIsolationLevel('INVALID TRANSACTION ISOLATION LEVEL');
    }

    /**
     * Test, that the methods exception->getCode and exception->getMessage work like errorNo and errorMsg.
     */
    public function testExceptionGetCodeAndExceptionGetMessageReturnSameResultsAsErrorNoAndErrorMsg()
    {
        $expectedCode = self::EXPECTED_MYSQL_SYNTAX_ERROR_CODE;
        $expectedMessage = self::EXPECTED_MYSQL_SYNTAX_ERROR_MESSAGE;

        try {
            $this->database->execute("INVALID SQL QUERY");
            $actualCode = 0;
            $actualMessage = '';
        } catch (\Exception $exception) {
            $actualCode = $exception->getCode();
            $actualMessage = $exception->getMessage();
        }

        $this->assertSame($expectedCode, $actualCode, 'A mysql syntax error should produce an exception with the expected code');
        $this->assertSame($expectedMessage, $actualMessage, 'A mysql syntax error should produce an exception with the expected message');
    }


    /**
     * Assert a given error level and a given error message
     *
     * @param integer $errorLevel   Error number as defined in http://php.net/manual/en/errorfunc.constants.php
     * @param string  $errorMessage Error message
     *
     * @return boolean Returns true on assertion success
     */
    protected function assertError($errorLevel, $errorMessage)
    {
        foreach ($this->errors as $error) {
            if ($error["errorMessage"] === $errorMessage
                && $error["errorLevel"] === $errorLevel
            ) {
                return true;
            }
        }

        $this->fail(
            "No error with level " . $errorLevel . " and message '" . $errorMessage . "' was triggered"
        );
    }

    public function testQuoteIdentifierWithValidValues()
    {
        $this->loadFixtureToTestTable();
        $quotedIdentifier = $this->database->quoteIdentifier('OXID');

        $expectedResult = [
            [self::FIXTURE_OXID_1]
        ];
        $resultSet = $this->database
            ->select("SELECT OXID FROM " . self::TABLE_NAME . " WHERE OXID = '" . self::FIXTURE_OXID_1 . "' ORDER BY " . $quotedIdentifier);
        $actualResult = $resultSet->fetchAll();

        $this->assertSame($expectedResult, $actualResult);
    }

    /**
     * @param $identifier
     * @param $expectedMessage
     *
     * @dataProvider dataProviderTestQuoteIdentifierWithInvalidValues
     */
    public function testQuoteIdentifierWithInvalidValues($identifier, $expectedMessage)
    {
        $this->setExpectedException('OxidEsales\EshopCommunity\Core\Exception\DatabaseException', $expectedMessage);

        $quotedIdentifier = $this->database->quoteIdentifier($identifier);

        $this->database->select('SELECT * FROM ' . self::TABLE_NAME . ' ORDER BY ' . $quotedIdentifier);
    }

    public function dataProviderTestQuoteIdentifierWithInvalidValues()
    {
        return [
            [
                // A arbitrary string will be converted in a column name
                'SELECT * from oxuser',
                'Unknown column \'SELECT * from oxuser\' in \'order clause\''
            ],
            [
                // A arbitrary string, which contains a backtick, will be converted in a column name
                'columnName ` columnName',
                'Unknown column \'columnName  columnName\' in \'order clause\''
            ],
        ];
    }

    /**
     * @dataProvider dataProviderTestQuoteWithInvalidValues
     *
     * @param mixed $value
     * @param mixed $expectedQuotedValue
     * @param string $expectedException
     * @param string $message
     */
    public function testQuoteWithInvalidValues($value, $expectedQuotedValue, $expectedException, $message)
    {
        $this->loadFixtureToTestTable();

        $actualQuotedValue = $this->database->quote($value);
        $this->assertSame($expectedQuotedValue, $actualQuotedValue, $message);

        $this->setExpectedException($expectedException);

        $query = "SELECT OXID FROM " . self::TABLE_NAME . " WHERE OXID = {$actualQuotedValue}";
        $resultSet = $this->database->select($query);
        $resultSet->fetchAll();
    }

    public function testExceptionForDuplicatedEntry()
    {
        $tableName = self::TABLE_NAME;
        $id = self::FIXTURE_OXID_1;
        $this->database->execute("ALTER TABLE `oxdoctrinetest`ADD UNIQUE `oxid` (`oxid`);");
        $this->database->execute("INSERT INTO $tableName (OXID) VALUES ('$id');");

        try {
            $this->database->execute("INSERT INTO $tableName (OXID) VALUES ('$id');");
        } catch (DatabaseException $e) {
            $this->assertEquals(DatabaseInterface::DUPLICATE_KEY_ERROR_CODE, $e->getCode());
            return;
        }

        $this->fail('Database exception must be thrown due to duplicated entry.');
    }

    public function dataProviderTestQuoteWithInvalidValues()
    {
        return [
            [array('key' => 'value'), false, self::DATABASE_EXCEPTION_CLASS, 'An array will be converted into boolean "false" and an exception is thrown, when the statement is executed '],
            [new \stdClass(), false, self::DATABASE_EXCEPTION_CLASS, 'An object will be converted into boolean "false" and an exception is thrown, when the statement is executed'],
        ];
    }


    /**
     * Test, that affected rows is set to the expected values by consecutive calls to execute()
     */
    public function testExecuteSetsAffectedRows()
    {
        $this->loadFixtureToTestTable();

        /** One row will be updated by the query */
        $expectedAffectedRows = 1;
        $actualAffectedRows = $this->database->execute('UPDATE ' . self::TABLE_NAME . ' SET oxuserid = "somevalue" WHERE OXID = ?', array(self::FIXTURE_OXID_1));

        $this->assertEquals($expectedAffectedRows, $actualAffectedRows, '1 row was updated by the query');


        /** Two rows will be updated by the query */
        $expectedAffectedRows = 2;
        $actualAffectedRows = $this->database->execute('UPDATE ' . self::TABLE_NAME . ' SET oxuserid = "someothervalue" WHERE OXID IN (?, ?)', array(self::FIXTURE_OXID_1, self::FIXTURE_OXID_2));

        $this->assertEquals($expectedAffectedRows, $actualAffectedRows, '2 rows was updated by the query');
    }

    /**
     * Test, that the method 'execute' works for insert and delete.
     */
    public function testExecuteWithInsertAndDelete()
    {
        $this->truncateTestTable();

        $exampleOxId = self::FIXTURE_OXID_1;

        $affectedRows = $this->database->execute("INSERT INTO " . self::TABLE_NAME . " (OXID) VALUES ('$exampleOxId');");

        $this->assertSame(1, $affectedRows);
        $this->assertTestTableHasOnly($exampleOxId);

        $affectedRows = $this->database->execute("DELETE FROM " . self::TABLE_NAME . " WHERE OXID = '$exampleOxId';");

        $this->assertSame(1, $affectedRows);
        $this->assertTestTableIsEmpty();
    }

    /**
     * Test, that the method 'getRow' gives an empty array with empty table and default fetch mode.
     */
    public function testGetRowEmptyTableDefaultFetchMode()
    {
        $result = $this->database->getRow('SELECT * FROM ' . self::TABLE_NAME);

        $this->assertInternalType('array', $result);
        $this->assertEmpty($result);
    }

    /**
     * Test, that the method 'getAll' leads to unique rows with the SQL clause 'ORDER BY rand()'.
     */
    public function testGetAllWithOrderByRand()
    {
        $resultSet = $this->database->select('SELECT oxid FROM oxarticles ORDER BY RAND()');
        $rows = $resultSet->fetchAll();
        $oxIds = [];

        foreach ($rows as $row) {
            $oxIds[] = $row[0];
        }

        $this->assertArrayIsUnique($oxIds);
    }

    /**
     * Test, that the method 'moveNext' leads to unique rows with the SQL clause 'ORDER BY rand()'.
     */
    public function testMoveNextWithOrderByRand()
    {
        $resultSet = $this->database->select('SELECT oxid FROM oxarticles ORDER BY RAND()');
        $oxIds = [];

        while (!$resultSet->EOF) {
            $oxIds[] = $resultSet->fields[0];
            $resultSet->fetchRow();
        }

        $this->assertArrayIsUnique($oxIds);
    }

    /*
     * Test Case: All possible parameters for setConnectionParameters are set correctly.
     *
     */
    public function testSetConnectionParametersAllParametersSet()
    {
        $this->setProtectedClassProperty($this->database, 'connectionParameters', array());
        $connectionParametersFromConfigInc = array(
            'default' => array(
                'databaseHost'     => 'myDatabaseHost',
                'databaseName'     => 'myDatabaseName',
                'databaseUser'     => 'myDatabaseUser',
                'databasePassword' => 'myDatabasePassword',
                'databasePort'     => 'myDatabasePort'
            )
        );
        $this->database->setConnectionParameters($connectionParametersFromConfigInc);
        $expectedConnectionParameters = array(
            'driver'   => 'pdo_mysql',
            'host'     => 'myDatabaseHost',
            'dbname'   => 'myDatabaseName',
            'user'     => 'myDatabaseUser',
            'password' => 'myDatabasePassword',
            'port'     => 'myDatabasePort',
            'driverOptions' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET @@SESSION.sql_mode=''"
            )
        );
        $this->assertEquals(
            $expectedConnectionParameters,
            $this->getProtectedClassProperty($this->database, 'connectionParameters'),
            "Not all input parameters are set to the correct place in the output array."
        );
    }

    /*
     * Test Case: not all parameters for setConnectionParameters are set
     */
    public function testSetConnectionParametersNoParametersSet()
    {
        $this->setProtectedClassProperty($this->database, 'connectionParameters', array());
        $connectionParametersFromConfigInc = array();
        $this->database->setConnectionParameters($connectionParametersFromConfigInc);
        $expectedConnectionParameters = array();
        $this->assertEquals(
            $expectedConnectionParameters,
            $this->getProtectedClassProperty($this->database, 'connectionParameters'),
            "There can be no parameters in the array with no input parameters."
        );
    }

    /*
     * After applying the driverOptions to the Doctrine DriverManager, in our case the sql_mode should be
     * set on the database connection.
     */
    public function testAddDriverOptionsSetsSqlMode()
    {
        $query = 'SELECT @@SESSION.sql_mode';

        $expectedSqlMode = '';
        $actualSqlMode = $this->database->getOne($query);
        $this->assertSame($expectedSqlMode,
            $actualSqlMode,
            "The sql_mode variable on the database is not the expected one."
        );
    }

    /**
     * Assert, that the given array is unique.
     *
     * @param array $expectUnique The array we want to be unique.
     */
    private function assertArrayIsUnique($expectUnique)
    {
        $unique = array_unique($expectUnique);
        $this->assertEquals($unique, $expectUnique, 'There should not be any doubled entries in the given array!');
    }

}
