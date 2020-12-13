<?php

namespace App\db;

class DatabaseConnection {
    const SERVER = "localhost";
    const USERNAME = "";
    const PASSWORD = "";
    const DATABASE = "";
    private $_connection;
    private static $_instance; 

    private function __construct()
    {
        try {
            $this->_connection  = new \mysqli(self::SERVER , self::USERNAME , self::PASSWORD , self::DATABASE); 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function connect()
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function closeConnection($conn){
        $this->_connection->close();
    }

    public function getConnection()
    {
        return $this->_connection;
    }
}
