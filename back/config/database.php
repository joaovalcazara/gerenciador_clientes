<?php

class Database{

    protected static $db;

    private function __construct(){
        $host = "127.0.0.1";
        $dbname = "kabum";
        $username = "root";
        $password = "admin";

        try {
            self::$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (PDOException $e) {
            echo "Erro na conexão com o banco de dados: " . $e->getMessage();
            die();
        }

    }

    public static function getConexao(){ 
        if(!self::$db){ 
            new Database();
        }

        return self::$db;
    }
}



