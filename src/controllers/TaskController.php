<?php

namespace App\controllers;

use App\models\Task;

class TaskController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index($params)
    {
        $params["by"] = $params["by"] ?? 'asc';
        $tasks = new Task();
        $params["order"] = property_exists($tasks, $params['order']) ? $params['order'] : 'name';
        $params["tasks"] = $tasks->getTasks($params);
        $params["page"] = $params["page"] ?? 1;
        $params["count"] = $tasks->getTaskCount();
        $this->view('index', $params);
    }


    public function add($params)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $task = new Task();
            
            $errors = $task->validate($_POST);
            if (count($errors)) {
               $params["errors"] = $errors;
            } else {
                $task->name = htmlspecialchars($_POST['name']);
                $task->email = htmlspecialchars($_POST['email']);
                $task->text = htmlspecialchars($_POST['text']);
                $task->save();
                header("Location: /task/index/message/ok");
            }
           
        }
        $this->view('form', $params);
    }


    public function edit($params)
    {
        if (!isset($_SESSION['user'])) {
             header("Location: /admin/index");
             exit;
        }
        
        if($params['id']){
            $task = new Task();
            $res = $task->getTask($params['id']);
            if ($res) {
                if($_SERVER["REQUEST_METHOD"] == 'POST'){
                  
                    if ($res["text"] != htmlspecialchars($_POST['text'])) {
                        $task->edit_by_admin = '1';
                    }
                    $task->name = htmlspecialchars($_POST['name']);
                    $task->email = htmlspecialchars($_POST['email']);
                    $task->text = htmlspecialchars($_POST['text']);
                    $task->status = ($_POST['status'] == 'true') ? '1' : '0';
                    $task->save((int)$_POST['id']);
                    header("Location: /task/index/");
                }
                $this->view('form', array_merge($params, $res));
            }else{
                header("Location: /task/index");
            }
        }else{
            header("Location: /task/index");
        }
    }
    
}
