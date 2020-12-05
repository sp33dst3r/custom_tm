<?php
namespace App\models;
use \PDO;
class Model
{
    public function __construct()
    {
        $db_creds_array = file($_SERVER["DOCUMENT_ROOT"]."/.env");
        $db_creds = [];
        foreach ($db_creds_array as $value) {
            $db_data = explode("=", $value);
            $db_creds[$db_data[0]] = trim($db_data[1]);
        }
        $this->pdo = new PDO('mysql:host='.$db_creds['host'].';dbname='.$db_creds['dbname'], $db_creds['user'], $db_creds['password']); 
    }
}
