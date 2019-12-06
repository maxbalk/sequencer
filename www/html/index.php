<?php
define("ROOT", realpath(__DIR__ . "/../"));
require_once('models/model.php');
require_once('models/user.php');
require_once('views/view.php');

error_reporting(E_ALL);

session_start();
$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
$action = empty($_POST['action']) ? '' : $_POST['action'];

$route = empty($_POST['route']) ? '' : $_POST['route'];
if($route == 'loginPage'){
    require_once('views/login.php');
    $loginPage = new loginPage();
    $loginPage->build();
} elseif($route == 'aboutPage'){
    require_once('views/about.php');
    $aboutPage = new aboutPage();
    $aboutPage->build();
} elseif($route == 'doLogin'){
    $user = new User();
    $user->handleLogin();
} elseif($route == ''){
    $user = new User();
    $user->createUser('test1', 'pass');
    require_once('views/app.php');
    $homepage = new appPage();
    $homepage->build($loggedIn);
}