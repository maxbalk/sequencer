<?php
define("ROOT", realpath(__DIR__ . "/../"));
require_once('models/model.php');
require_once('models/user.php');
require_once('views/view.php');

session_start();
$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
$route = empty($_GET['route']) ? '' : $_GET['route'];
if($route == 'loginPage'){
    require_once('views/login.php');
    $loginPage = new loginPage();
    $error = empty($_GET['error']) ? '' : "incorrect username or password";
    $loginPage->build($error);
} elseif($route == 'aboutPage'){
    require_once('views/about.php');
    $aboutPage = new aboutPage();
    $aboutPage->build();
} elseif($route == 'doLogin'){
    $user = new User();
    $user->handleLogin();
} elseif($route == 'logout'){
    $user = new User();
    $user->handleLogout();
    header("Location: /");
} elseif($route == '' || $route == 'home'){
    $user = new User();
    $user->createUser('test', 'pass');
    require_once('views/app.php');
    $homepage = new appPage();
    $homepage->build($loggedIn);
}