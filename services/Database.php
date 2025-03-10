<?php

namespace App\Services;

class Database
{
    private $client;
    private $db;

    public function __construct()
    {
        $this->client = new \MongoDB\Client("mongodb://admin:adminpassword@localhost:27017/");
        $this->db = $this->client->selectDatabase("bibliotheque");
    }

    public function getCollection($collection)
    {
        return $this->db->$collection;
    }
}
