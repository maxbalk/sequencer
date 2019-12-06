<?php
define("ROOT", realpath(__DIR__ . "/../"));
require_once('models/model.php');
require_once('models/sequence.php');

session_start();

$action = empty($_GET['action']) ? '' : $_GET['action'];
if($action == 'saveSequence'){
    $content = $_POST['sequence'];
    if(strlen($content) == 769){
        print "empty";
    } else {
        $username = $_SESSION['loggedin'];
        $name = $_POST['loopName'];
        $sequence = new Sequence();
        if($sequence->saveSequence($content, $name, $username)){
            print "sequence saved";
        } else {
            print "there was an error saving the current sequence";
        }
    }   
}
