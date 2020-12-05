<?php
use App\Router\Router;

session_start();
function pre($data)
{
    echo "<pre>", print_r($data), "</pre>";
}
function pred($data)
{
    pre($data); die("<br />----");
}
require __DIR__ . '/vendor/autoload.php';
//var_dump(get_declared_classes ( ) );
//init routing module
new Router();

//$KeywordPlanner = new Alphabet\Google\AdWord\KeywordPlanner();