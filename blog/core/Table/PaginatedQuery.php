<?php

namespace Core\Table;

use Pagerfanta\Adapter\AdapterInterface;

class PaginatedQuery extends Table implements AdapterInterface
{
    private $param1;
    private $param2;
    protected $db;
    /**
     * @var string
     */
    private $results;
    /**
     * @var string
     */
    private $countResults;

    public function __construct($db, string $results, string $countResults)
    {
        parent::__construct($db);
        $this->results = $results;
        $this->countResults= $countResults;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults(): int
    {
        $count = $this->db->query("{$this->countResults}");

        $result = $count[0]->total;

        return intval($result);
    }

    /**
     * Returns an slice of the results.
     *
     * @param integer $offset The offset.
     * @param integer $length The length.
     *
     * @return array|\Traversable The slice.
     */
    public function getSlice($offset, $length): array
    {
        $this->param1 = intval($offset);
        $this->param2 = intval($length);

        return $this->db->query("{$this->results} LIMIT {$this->param1}, {$this->param2}");

    }
}
