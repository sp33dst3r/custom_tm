<?php
namespace App\controllers;

use App\models\Admin;


class AdminController extends Controller
{
    public function index($params)
    {
        if ($_SESSION['user']) header("Location: /task/index");

        if ($_SERVER["REQUEST_METHOD"] == 'POST') {
            $admin = new Admin();
            $errors = $admin->validate($_POST);
            if (!count($errors)) {
                $params = $admin->login($_POST);
                if ($params['id']) {
                    $_SESSION['user'] = 'admin';
                    header("Location: /task/index");
                }
            } else {
                $params['errors'] = $errors;
            }
        }
        $this->view('login', $params);
    }

    public function logout()
    {
        $_SESSION = null;
        session_unset();

        session_destroy();
        header("Location: /admin/index");
    }
}