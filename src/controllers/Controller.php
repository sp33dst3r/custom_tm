<?php
namespace App\controllers;

use Exception;

class Controller
{
    public function __construct()
    {
     
       
    }
    public function __call($func, $arguments) {
        if($func == 'view'){
            if($arguments[1]) extract($arguments[1]);
            
            ob_start();

            try {
                $file = $_SERVER["DOCUMENT_ROOT"].'/src/views/'.$arguments[0].'.php';
                if (!file_exists($file)) {
                    throw new Exception("View '".$file."' doesn't exit!");
                }
                include $file;
            } catch(Exception $e) {
                echo "<h1>Error: ",  $e->getMessage(), "</h1>\n";
            }
            $output = ob_get_clean();
    
            echo $output;

        } else {
            throw new \Exception("OOps, something wrong )))", 1);
        }
    }
    
}