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
 * @link          http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2016
 * @version       OXID eShop CE
 */
namespace OxidEsales\Eshop\Core\Database\Adapter;

use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\Driver\Statement;

/**
 * The doctrine statement wrapper, to support the old adodblite interface.
 *
 * @package OxidEsales\Eshop\Core\Database\Adapter
 */
class DoctrineResultSet
{

    /**
     * @var bool Did we reach the end of the results?
     */
    public $EOF = true;

    public $fields = array();

    /**
     * @var PDOStatement The doctrine adapted statement.
     */
    protected $adapted = null;

    /**
     * @var bool Was the first element already fetched?
     */
    private $fetchedFirst = false;

    /**
     * DoctrineResultSet constructor.
     *
     * @param Statement $adapted The statement we want to wrap in this class.
     */
    public function __construct(Statement $adapted)
    {
        $this->setAdapted($adapted);

        if (0 < $this->getAdapted()->rowCount()) {
            $this->EOF = false;

            $this->fields = $this->getAdapted()->fetch();

            $this->executeAdapted();
        } else {
            // @todo: double check, if this path or the DoctrineEmptyResultSet could be removed
            $this->setToEmptyState();
        }
    }

    /**
     * Fetch the next row from the database. If there is no next row, it gives back false.
     *
     * @return false|array The next row.
     */
    public function fetchRow()
    {
        return $this->getAdapted()->fetch();
    }

    /**
     * Count the result rows of the corresponding statement.
     *
     * @return int How many rows are included in the result?
     */
    public function recordCount()
    {
        return $this->getAdapted()->rowCount();
    }

    /**
     * Fetch all rows from the corresponding statement.
     *
     * @return array The complete result set as an array of associative arrays.
     */
    public function getAll()
    {
        $this->getAdapted()->execute();

        return $this->getAdapted()->fetchAll();
    }

    /**
     * Check, if we already reached the end of the results.
     *
     * @return bool Is the end of the result set reached?
     */
    public function EOF()
    {
        return $this->EOF;
    }

    /**
     * Close the pointer to the database connection.
     */
    public function close()
    {
        if ($this->isEmpty()) {
            $this->EOF = true;
            $this->fields = array();
        } else {
            $this->EOF = false;
            $this->fields = array();
        }

        $this->getAdapted()->closeCursor();
    }

    /**
     * Get information about the column, specified by the given index.
     *
     * @param int $columnIndex The index of the column of this result set.
     *
     * @return \stdClass An object, filled with the column information.
     */
    public function fetchField($columnIndex)
    {
        $metaInformation = $this->getAdapted()->getColumnMeta($columnIndex);

        $result = new \stdClass();
        $result->name = $metaInformation['name'];
        $result->table = $metaInformation['table'];
        $result->max_length = $metaInformation['len'];
        $result->not_null = (int) in_array('not_null', $metaInformation['flags']);
        $result->primary_key = (int) in_array('primary_key', $metaInformation['flags']);
        $result->type = strtolower($metaInformation['native_type']);

        return $result;
    }

    /**
     * Give back the number of columns the adapted result set has.
     *
     * @return int The number of columns of the adapted result set.
     */
    public function fieldCount()
    {
        return $this->getAdapted()->columnCount();
    }

    /**
     * Get a specific column value.
     *
     * @param string|int $columnKey The key of the wished column.
     *
     * @return null|boolean|string|array The column value (string or array). If the result set is empty or the last row is reached, we give back false. If the column name is not present, we give back null.
     */
    public function fields($columnKey)
    {
        if ($this->isEmpty()) {
            if (0 === $columnKey) {
                return false;
            } else {
                return null;
            }
        } else {
            if (0 === $columnKey) {
                // this case is here, cause adodblite checks with empty
                //   empty(0) is true   =>   we give back the complete array...

                return $this->fields;
            } else {
                return $this->fields[$columnKey];
            }
        }
    }

    /**
     * Get the given number of rows, from the current row pointer on, as an array.
     *
     * @param int $numberOfRows The number of rows to fetch.
     *
     * @return array The rows of the corresponding statement, starting at the current row pointer.
     */
    public function getArray($numberOfRows)
    {
        return $this->getRows($numberOfRows);
    }

    /**
     * Get the given number of rows from the current row pointer on.
     *
     * @param int $numberOfRows The number of rows to fetch.
     *
     * @return array The rows of the corresponding statement, starting at the current row pointer.
     */
    public function getRows($numberOfRows)
    {
        $result = array();

        for ($index = 0; $index < $numberOfRows; $index++) {
            $row = $this->fetchRow();

            if (!$this->EOF() && !is_bool($row)) {
                $result[] = $row;
            }
        }

        return $result;
    }

    /**
     * Load the next row from the database.
     *
     * @return bool Is there another row?
     */
    public function moveNext()
    {
        if ($this->EOF()) {
            return false;
        }

        if (!$this->isFetchedFirst()) {
            $this->fetchRowIntoFields();
        }
        $this->fetchRowIntoFields();

        if (!$this->fields) {
            $this->EOF = true;

            return false;
        }

        return true;
    }

    /**
     * Load the n-th row.
     *
     * @param int $rowIndex The number of the row to load.
     *
     * @return bool Is there another row?
     */
    public function move($rowIndex)
    {
        if ($this->isEmpty()) {
            $this->setToEmptyState();

            return false;
        }

        if ($this->isFetchedFirst()) {
            $this->executeAdapted();
        }

        if (0 === $rowIndex) {
            return true;
        }

        $lastFields = $this->fields;

        while (0 < $rowIndex) {
            $lastFields = $this->fields;

            if (!$this->moveNext()) {
                $rowIndex = 0;
                $this->fields = $lastFields;
                $this->EOF = false;
            }

            $rowIndex--;
        }

        return true;
    }

    /**
     * Move the row pointer to the first row of the given result.
     *
     * @return bool True for empty or there exists another row, false for end of rows reached.
     */
    public function moveFirst()
    {
        if ($this->isEmpty()) {
            return true;
        }

        $result = $this->move(0);

        $this->fields = $this->getAdapted()->fetch();

        return $result;
    }

    /**
     * Move the row pointer to the last row of the given result set.
     *
     * @return bool Is this result set not empty?
     */
    public function moveLast()
    {
        if ($this->isEmpty()) {
            return false;
        } else {
            $lastIndex = $this->recordCount();

            return $this->move($lastIndex);
        }
    }

    /**
     * Getter for the adapted statement.
     *
     * @return PDOStatement The adapted statement.
     */
    protected function getAdapted()
    {
        return $this->adapted;
    }

    /**
     * Setter for the adapted statement.
     *
     * @param PDOStatement $adapted The adapted statement.
     */
    protected function setAdapted($adapted)
    {
        $this->adapted = $adapted;
    }

    /**
     * Getter for the fetched first flag.
     *
     * @return boolean Is the first row of the adapted statement already fetched?
     */
    private function isFetchedFirst()
    {
        return $this->fetchedFirst;
    }

    /**
     * Setter for the fetched first flag.
     *
     * @param boolean $fetchedFirst Is the first row of the adapted statement already fetched?
     */
    private function setFetchedFirst($fetchedFirst)
    {
        $this->fetchedFirst = $fetchedFirst;
    }

    /**
     * (Re-)execute the adapted statement.
     */
    private function executeAdapted()
    {
        $this->getAdapted()->execute();
    }

    /**
     * Fetch the next row into the fields attribute.
     */
    private function fetchRowIntoFields()
    {
        $this->fields = $this->getAdapted()->fetch();

        $this->setFetchedFirst(true);
    }

    /**
     * Set the state of this wrapper to 'empty'.
     */
    private function setToEmptyState()
    {
        $this->EOF = true;
        $this->fields = false;
    }

    /**
     * Determine, if the wrapped result set is empty.
     *
     * @return bool Is the wrapped result set empty?
     */
    private function isEmpty()
    {
        return 0 === $this->recordCount();
    }
}