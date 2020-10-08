<?php

namespace Album\Api;


use Laminas\Mvc\Controller\AbstractRestfulController;

class AlbumController extends AbstractRestfulController
{
    public function get($id)
    {
        // associated with GET request with identifier
    }

    public function getList()
    {
        // associated with GET request without identifier
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