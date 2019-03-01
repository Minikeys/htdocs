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
    /**
     * @var string
     */
    private $orderResults;
    /**
     * @var int
     */
    private $filter;
    /**
     * @var array
     */
    private $filterparam;

    public function __construct($db, string $results, string $orderResults, string $countResults, int $filter = null , array $filterparam = [])
    {
        parent::__construct($db);
        $this->results = $results;
        $this->countResults= $countResults;
        $this->orderResults = $orderResults;
        $this->filter = $filter;
        $this->filterparam = $filterparam;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults(): int
    {
        if(is_null($this->filter)){

            $count = $this->db->query("{$this->countResults}");

        } elseif(is_null($this->filterparam['value2'])){

            $count = $this->db->query("{$this->countResults} WHERE {$this->filterparam['value']} = {$this->filterparam['id']}");

        }else{

            $count = $this->db->query("{$this->countResults} WHERE {$this->filterparam['value']} = {$this->filterparam['id']} AND {$this->filterparam['value2']} = {$this->filterparam['id2']}");

        }


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

        if(is_null($this->filter)){

            return $this->db->query("{$this->results} {$this->orderResults} LIMIT {$this->param1}, {$this->param2}");

        } elseif(is_null($this->filterparam['value2'])){

            return $this->db->query("{$this->results} WHERE {$this->filterparam['value']} = {$this->filterparam['id']} {$this->orderResults} LIMIT {$this->param1}, {$this->param2}");

        } else {

            return $this->db->query("{$this->results} WHERE {$this->filterparam['value']} = {$this->filterparam['id']} AND {$this->filterparam['value2']} = {$this->filterparam['id2']} {$this->orderResults} LIMIT {$this->param1}, {$this->param2}");

        }



    }
}
