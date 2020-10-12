<?php

namespace Album\Api;

use Album\Model\AlbumTable;
use Laminas\Mvc\Controller\AbstractRestfulController;
use Laminas\View\Model\ViewModel;

class AlbumController extends AbstractRestfulController
{

    // Add this property:
    private $table;

    // Add this constructor:
    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }

    public function get($id)
    {
        // associated with GET request with identifier
    }

    public function getList()
    {
        try {
            $data = $this->table->fetchAll();
        } catch (\Exception $exception) {
            throw $exception;
        }
    }


    public function create($data)
    {
        // associated with POST request
    }

    public function update($id, $data)
    {
        // associated with PUT request
    }

    public function delete($id)
    {
        // associated with DELETE request
    }
}
