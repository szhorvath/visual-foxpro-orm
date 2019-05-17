<?php

namespace Szhorvath\FoxproDB;

use COM;
use InvalidArgumentException;
use Szhorvath\FoxproDB\Exceptions\ClassNotFoundException;

/**
 * Record set parser
 */
class RecordSet
{

    /**
     * ADOB connetionc
     *
     * @var COM
     */
    protected $connection = null;

    /**
     * ADODB recodeset
     *
     * @var recordset
     */
    protected $recordSet = null;

    /**
     * Recordset headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Sets variables
     */
    public function __construct()
    {
        throw_if(!class_exists('COM'), new ClassNotFoundException('COM class not found'));
        $this->recordSet = new COM("ADODB.Recordset");
    }

    /**
     * Opens records set and execute query
     *
     * @param COM $connection
     * @param string $query
     * @return RecordSet
     */
    public function open($connection, $query)
    {
        $this->recordSet->Open($query, $connection, 1, 3);
        return $this;
    }

    /**
     * Count records
     *
     * @return integer
     */
    public function count(): int
    {
        return (int)$this->recordSet->RecordCount();
    }


    /**
     * Gets column headers
     *
     * @return array
     */
    public function getHeaders()
    {
        for ($i = 0; $i < $this->headerCount(); $i++) {
            $this->headers[$i] = $this->recordSet->Fields($i)->Name;
        }

        return $this->headers;
    }

    /**
     * Get recordset
     *
     * @return Recordset
     */
    public function getRecordSet()
    {
        return $this->recordSet;
    }

    /**
     * Returns the number of columns
     *
     * @return int
     */
    public function headerCount(): int
    {
        return (int)$this->recordSet->Fields->Count();
    }


    /**
     * Returns records as array format
     *
     * @return array
     */
    public function toArray()
    {
        $this->collection()->toArray();
    }

    /**
     * Returns records as a collection
     *
     * @return Illuminate\Support\Collection
     */
    public function collection()
    {
        if (!$this->count()) {
            return collect([]);
        }

        $data = [];
        while (!$this->recordSet->EOF) {
            foreach ($this->getHeaders() as $key => $header) {
                $row[$header] = $this->encodeField($this->recordSet[$key]->Value);
            }
            $data[] = (object)$row;
            $this->recordSet->MoveNext();
        }

        return collect($data);
    }

    /**
     * Paginate records
     *
     * @param integer $page
     * @param integer $perPage
     * @return Illuminate\Support\Collection
     */
    public function paginate($page = 1, $perPage = 10)
    {
        if (!$this->count()) {
            return collect([]);
        }

        $this->recordSet->PageSize = $perPage;
        $this->recordSet->AbsolutePage = $page;

        $data = [];
        $rowCount = 0;
        while (!$this->recordSet->EOF and $rowCount < $perPage) {
            foreach ($this->getHeaders() as $key => $header) {
                $row[$header] = $this->encodeField($this->recordSet[$key]->Value);
            }
            $data[] = (object)$row;

            $this->recordSet->MoveNext();
            $rowCount++;
        }

        $pagination               = new \stdClass;
        $pagination->total        = $this->recordSet->RecordCount();
        $pagination->per_page     = $perPage;
        $pagination->current_page = $page;
        $pagination->total_pages  = $this->recordSet->PageCount();

        return collect([
            'data' => $data,
            'meta' => (object)[
                'pagination' => $pagination
            ],
        ]);
    }

    /**
     * Return records as string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->recordSet->GetString();
    }

    /**
     * Close recordset
     *
     * @return void
     */
    public function close()
    {
        $this->recordSet->Close();
    }

    /**
     * Encode and trim record values
     *
     * @param string $value
     * @return string|null
     */
    protected function encodeField(string $value)
    {
        return trim(utf8_encode($value)) ?: null;
    }
}
