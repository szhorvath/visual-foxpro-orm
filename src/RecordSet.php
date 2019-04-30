<?php

namespace Szhorvath\FoxproDB;

use InvalidArgumentException;

/**
 * Record set parser
 */
class RecordSet
{
    /**
     * ADODB recodeset
     *
     * @var recordset
     */
    protected $recordSet;

    /**
     * Recordset headers
     *
     * @var array
     */
    public $columns;

    /**
     * Sets variables
     *
     * @param recorset $recordSet
     * @param array $columns
     */
    public function __construct($recordSet, array $columns)
    {
        $this->columns = $columns;
        $this->recordSet = $recordSet;
    }

    /**
     * Gets columns
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Gets recorset
     *
     * @return recorset
     */
    public function getRecordSet()
    {
        return $this->recordSet;
    }

    /**
     * Parses recordset
     *
     * @param recorset $rs
     * @return Recorset
     */
    public static function parse($rs)
    {
        throw_if(is_null($rs), new InvalidArgumentException('Record set is empty'));

        for ($i = 0; $i < $rs->Fields->Count(); $i++) {
            $columns[$i] = $rs->Fields($i)->Name;
        }

        return new static($rs, $columns);
    }

    /**
     * Returns records as array format
     *
     * @return array
     */
    public function toArray()
    {
        $data = [];
        $rowCount = 0;
        while (!$this->recordSet->EOF) {
            foreach ($this->columns as $key => $column) {
                $row[$column] = $this->encodeField($this->recordSet[$key]->Value);
            }
            $data[] = $row;
            $rowCount++;// increments rowcount
            $this->recordSet->MoveNext();
        }

        return $data;
    }

    /**
     * Returns records as a collection
     *
     * @return Illuminate\Support\Collection
     */
    public function toObject()
    {
        $data = [];
        $rowCount = 0;
        while (!$this->recordSet->EOF) {
            foreach ($this->columns as $key => $column) {
                $row[$column] = $this->encodeField($this->recordSet[$key]->Value);
            }
            $data[] =(object) $row;
            $rowCount++; // increments rowcount
            $this->recordSet->MoveNext();
        }

        return collect($data);
    }

    /**
     * Encode and trim record values
     *
     * @param string $value
     * @return string|null
     */
    protected function encodeField(string $value)
    {
        return trim(utf8_encode($value))?: null;
    }
}
