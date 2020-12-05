<?php
namespace App\models;

class Admin extends Model
{
    public $login;
    public $password;

    public function login($param)
    {
        $sql = "SELECT * FROM admin WHERE login = ? AND password = ?";

        $sth = $this->pdo->prepare($sql);
        $sth->execute([$_POST['login'], $_POST['password']]);
        $arr = $sth->fetch(\PDO::FETCH_ASSOC);
        if ($arr) {
            return $arr;
        } else {
            return array("fail_login"=>true, "errors" => []);
        }
    }

    public function validate($fields)
    {
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties();
        $errors = [];
       
        foreach($props as $prop){
            if(!$fields[$prop->name]){
                $errors[$prop->name] = 'empty field';
            }
            
            
        }
        return $errors;
    }
}