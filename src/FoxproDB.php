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

        throw_if(!class_exists('COM'), new ClassNotFoundException('COM class not found'));
        $this->connection = new COM("ADODB.Connection");

        $this->open();
    }

    /**
     * Opens a connection
     *
     * @return void
     */
    protected function open()
    {
        try {
            $this->connection->Open("Provider={$this->provider};Data Source={$this->source};Collating Sequence=machine;Mode=Read;CursorType=Keyset");
        } catch (\Throwable $th) {
            throw new \Exception("Couldn't open connection", 1);
        }
        return $this;
    }

    /**
     * Execute query
     *
     * @param string $query
     * @return void
     */
    public function query(string $query)
    {
        $this->recordSet = $this->connection->Execute($query);
        return $this;
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
        $rs = RecordSet::parse($this->recordSet);
        $data = $rs->toObject();

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
        $this->recordSet->Close();
        $this->connection->Close();
        return $this;
    }
}
