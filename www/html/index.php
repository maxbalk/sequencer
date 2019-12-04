<?php
define("ROOT", realpath(__DIR__ . "/../"));
require_once('model.php');
require_once('models/user.php');
require_once('views/view.php');
require_once('views/app.php');
require_once('views/about.php');

$homepage = new appPage();

$login = empty($_POST['action']) ? '' : $_POST['action'];
if($login = 'login'){
    $user = new User();
    $user->handleLogin();
}
$homepage->build();
