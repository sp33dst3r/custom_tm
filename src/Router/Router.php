<?php 
namespace App\Router;


use Exception;
use ReflectionClass;

class Router
{
    public function __construct()
    {
        $boot = explode("/", $_SERVER["REQUEST_URI"]);
        $res = $this->parseRoute($boot);
        try{
            $clazz = new ReflectionClass($res["controller"]);
            try{
                $method = $clazz->getMethod($res["action"]);
                $method->invoke(new $res["controller"](), $res["params"]);
            } catch(Exception $e) {
                echo "<h1>Error: ",  $e->getMessage(), "</h1>\n";
            }
        } catch(Exception $e) {
            echo "<h1>Error: ",  $e->getMessage(), "</h1>\n";
        }
    }

    public function parseRoute($boot) 
    {
        array_splice($boot, 0, 1); 
       
        
        $controller = $boot[0] == '' ? "TaskController" : ucfirst($boot[0]."Controller");
        $action = 'index';
        if ($boot[1]) {
            $action = $boot[1];
        }
        
        $params = [];
        if (count($boot) > 2) {
            $keys = [];
            $vals = [];
            $boot = array_values(array_diff($boot, array($boot[0], $boot[1])));
            foreach ($boot as $key => $param) {
                if($key % 2 == 0){
                    array_push($keys, $param);
                }else{
                    array_push($vals, $param);
                }
            }
            foreach($keys as $key => $val){
                if(isset($vals[$key])){
                    $params[$val] = $vals[$key];
                }
            }
           
        }
        
        return [
            "controller" => "\\App\\controllers\\".$controller,
            "action" => $action,
            "params" => $params
        ];
       
    }
}
