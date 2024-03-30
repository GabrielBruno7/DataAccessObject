<?php

class Database extends PDO
{
    public $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost;dbname=rapcard", "root", "");
    }

    public function setParams($statement, $parameters = array())
    {    
        foreach ($parameters as $key => $value)
        {
            $statement->setParam($statement, $key, $value);
        }
    }

    public function setParam($statement, $key, $value)
    {
        $statement->bindParam($key, $value);
    }

    public function queryp($rawQuery, $params = array())
    {
        $stmt = $this->conn->prepare($rawQuery);

        $this->setParams($stmt, $params);

        $stmt->execute();
        return $stmt;

    }

    public function select($rawQuery, $params = array()): array
    {
        $stmt = $this->queryp($rawQuery, $params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

}