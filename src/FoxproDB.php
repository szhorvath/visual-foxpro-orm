<?php

namespace Szhorvath\FoxproDB;

use COM;
use Szhorvath\FoxproDB\RecordSet;
use Szhorvath\FoxproDB\Exceptions\ClassNotFoundException;

class FoxproDB
{
    /**
     * ADODB connetion
     *
     * @var COM
     */
    protected $connection;

    /**
     * Source database file
     *
     * @var string
     */
    protected $source;

    /**
     * Database driver
     *
     * @var string
     */
    protected $provider;

    /**
     * ADODB record set
     *
     * @var recordset
     */
    protected $recordSet = null;

    /**
     * Instantiate a new connection
     *
     * @param iterable $config
     */
    public function __construct(iterable $config)
    {
        $this->provider = $config['provider'];
        $this->source = $config['source'];
        $this->openConnection();
    }

    /**
     * Opens a connection
     *
     * @return void
     */
    protected function openConnection()
    {
        throw_if(!class_exists('COM'), new ClassNotFoundException('COM class not found'));

        try {
            $this->connection = new COM("ADODB.Connection");
            $this->connection->Open("Provider={$this->provider};Data Source={$this->source};Collating Sequence=machine;Mode=Read;CursorType=Keyset");
        } catch (\Throwable $th) {
            throw new \Exception("Couldn't open connection", 1);
        }
    }

    /**
     * Execute query
     *
     * @param string $query
     * @return void
     */
    public function query(string $query)
    {
        $this->recordSet = new RecordSet();
        $this->recordSet->open($this->connection, $query);

        return $this;
    }

    /**
     * Returns number of rows
     *
     * @return int
     */
    public function count()
    {
        return $this->recordSet->count() > 0 ? $this->recordSet->count() : null;
    }

    /**
     * Sets source file
     *
     * @param string $source
     * @return void
     */
    public function setSource(string $source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Returns dataset
     *
     * @return Illuminate\Support\Collection|array
     */
    public function get()
    {
        $data = $this->recordSet->collection();
        $this->close();

        return $data;
    }

    /**
     * Returns the first record
     *
     * @return Illuminate\Support\Collection|null
     */
    public function first()
    {
        return $this->recordSet->count() ? $this->get()[0] : null;
    }

    /**
     * Returns paginated dataset
     *
     * @return Illuminate\Support\Collection|array
     */
    public function paginate(int $page = 1, int $perPage = 10)
    {
        $data = $this->recordSet->paginate($page, $perPage);
        $this->close();

        return $data;
    }

    /**
     * Closes connections
     *
     * @return void
     */
    public function close()
    {
        $this->recordSet->close();
        // $this->connection->Close();
        return $this;
    }
}
