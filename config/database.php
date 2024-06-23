<?php

class Database
{
    public $conn;       // pdo connect
    public $prepare;    // pdo prepare

    public function __construct()
    {
        $this->connect();
    }
    // start function connect to database using pdo object
    public function connect()
    {
        try {
            $dns = "mysql:host=localhost;dbname=scandiweb_Task;charset=utf8";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->conn = new PDO($dns, 'kareem', '195kj3af', $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    // end function connect

    //start function query
    public function query($sql)
    {
        $this->prepare = $this->conn->prepare($sql);
    }
    // end function query

    // start function bind
    public function bind($key, $value)
    {
        $this->prepare->bindParam($key, $value);
    }
    // end function bind

    public function execute()
    {
        $ex = $this->prepare->execute();
        return $ex ? true : false;
    }

    // select All function return all rows in table 
    public function selectAll()
    {
        $this->execute();
        return $this->prepare->fetchAll();
    }

    // select function return one row from table
    public function select()
    {
        $this->execute();
        return $this->prepare->fetch();
    }

    // function last insert id 
    public function last_id()
    {
        return $this->conn->lastInsertId();
    }
}
