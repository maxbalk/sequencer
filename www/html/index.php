<?php
define("ROOT", realpath(__DIR__ . "/../"));
require_once(ROOT.'/model.php');
require_once('views/app.php');
require_once('models/user.php');

$homepage = new appPage();

$login = empty($_POST['action']) ? '' : $_POST['action'];
if($login = 'login'){
    $user = new User();
    $user->handleLogin();
}
$homepage->build();
