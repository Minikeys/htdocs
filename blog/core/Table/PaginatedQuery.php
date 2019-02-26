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
    private $category_id;
    /**
     * @var string
     */
    private $orderResults;

    public function __construct($db, string $results, string $orderResults, string $countResults, $category_id)
    {
        parent::__construct($db);
        $this->results = $results;
        $this->countResults= $countResults;
        $this->category_id = $category_id;
        $this->orderResults = $orderResults;
    }

    /**
     * Returns the number of results.
     *
     * @return integer The number of results.
     */
    public function getNbResults(): int
    {
        if(is_null($this->category_id)){

            $count = $this->db->query("{$this->countResults}");

        } else {

            $count = $this->db->query("{$this->countResults} WHERE posts.category_id = {$this->category_id}");

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

        if(is_null($this->category_id)){
            return $this->db->query("{$this->results} {$this->orderResults} LIMIT {$this->param1}, {$this->param2}");
        } else {
            return $this->db->query("{$this->results} WHERE posts.category_id = {$this->category_id} {$this->orderResults} LIMIT {$this->param1}, {$this->param2}");

        }



    }
}
