<?php
define("ROOT",$_SERVER["DOCUMENT_ROOT"]);
define("ROOT2", realpath(__DIR__ . "/../"));
$conf = parse_ini_file(ROOT2.'/dbconfig.ini');
require_once(ROOT2.'/adapter.php');
if($_GET['']){
    include('views/app.html');
}
echo($conf);