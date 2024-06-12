<?php
class Database{
    public static function getConnect(){
        $host = "localhost";
        $dbname = "doan_php";
        $username = "vanchien";
        $password = "q_@RctV@/*]YZ.*L";

        $dsn = "mysql:host=$host;dbname=$dbname;charset=UTF8";
        try{
            $pdo = new PDO($dsn, $username, $password);
            
            if($pdo){
                return $pdo;
            }
        }
        catch(PDOexception $ex){
            echo $ex->getMessage();
            exit;
        }

    }
}