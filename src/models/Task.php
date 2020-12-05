<?php
namespace App\models;

class Task extends Model
{
    public $email;
    public $name;
    public $text;
    public $status;

    public function __construct()
    {
        parent::__construct();
    }

    public function getTasks($params)
    {
        $page = $params['page'] ?? 1;
        $order = $params['order'];
        $by = $params['by'];
        $sql = "SELECT * FROM tasks ORDER BY $order $by LIMIT 3 OFFSET ".((--$page)*3);
        $sth = $this->pdo->prepare($sql);
        $sth->execute();
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    public function getTask($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $sth = $this->pdo->prepare($sql);
        $sth->execute([(int)$id]);

        $task = $sth->fetch(\PDO::FETCH_ASSOC);
        return $task;
    }
    public function getTaskCount()
    {
        $sth = $this->pdo->prepare("SELECT count(*) as cnt FROM tasks");
        $sth->execute();
        $result = $sth->fetch(\PDO::FETCH_ASSOC)['cnt'];
        return $result;
    }

    public function save($id=null)
    {
        $edit_by_admin = '';
        if ($this->edit_by_admin) {
            $edit_by_admin = ', edit_by_admin = "1"';
        }
        if ($id) {
            
            $stmt = $this->pdo->prepare("UPDATE tasks SET name = ?, email = ?, text = ?, status = ? $edit_by_admin WHERE id = ?");
            $stmt->execute([$this->name, $this->email, $this->text, $this->status, $id]);  

        } else {

            $stmt = $this->pdo->prepare("INSERT INTO tasks (name, email, text) VALUES (?, ?, ?)");
            $stmt->execute([$this->name, $this->email, $this->text]);  
            
        }
    }
    
    public function validate($fields)
    {
        
        $reflect = new \ReflectionClass($this);
        $props = $reflect->getProperties();
        $errors = [];
       
        foreach ($props as $prop) {
            if ($prop->name == 'status') continue; //TODO: создать массив необязательных полей))

            if (!$fields[$prop->name]) {
                $errors[$prop->name] = 'empty field';
            }
            elseif ($prop->name == 'email' && !filter_var($fields[$prop->name], FILTER_VALIDATE_EMAIL)) {
                $errors[$prop->name] = 'email is not valid';
            }
            
        }
        return $errors;
    }
}