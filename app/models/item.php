<?php

namespace App\models;
use App\db\DatabaseConnection;

class Item {

    protected $db_instance = '';
    public function __construct()
    {
        $this->db_instance =  DatabaseConnection::connect();
    }

    protected function executeQuery($sql){
        $conn =   $this->db_instance->getConnection();
        $result = $conn->query($sql);
        return $result;
    }

    public function store($name){
        $sql = "INSERT INTO lists (name) VALUES ('" . $name . "')";
        $result = $this->executeQuery($sql);
        if ($result) {
            header('Location: '.$_SERVER['REQUEST_URI']);
        } else {
            echo "Error: " . $sql ;
        }
    }

    public function show(){
        $sql = "SELECT id, name FROM lists";
        $result = $this->executeQuery($sql);
        return  $result ;
    }
    
    public function update($id,$name){
        $sql = "UPDATE lists SET name='".$name."' WHERE id=".$id;
        $result = $this->executeQuery($sql);
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    public function delete($id){
        $sql = "DELETE FROM lists WHERE id=" . $id;
        $result = $this->executeQuery($sql);
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    public function __destruct() {
        $this->db_instance->closeConnection();
    }
}
