<?php
define("ROOT", realpath(__DIR__ . "/../"));
require_once('models/model.php');
require_once('models/sequence.php');

session_start();

$action = empty($_GET['action']) ? '' : $_GET['action'];
$username = empty($_SESSION['loggedin']) ? '' : $_SESSION['loggedin'];

if($action == 'saveSequence'){
    saveSequence($username);
} elseif($action == 'getSequences'){
    getSequences($username);
} elseif($action == 'loadSequence'){
    loadSequence($username);
}

function saveSequence($username){
    $content = $_POST['sequence'];
    if(strlen($content) == 769){
        print "empty";
    } else {
        $name = $_POST['loopName'];
        $sequence = new Sequence();
        if($sequence->saveSequence($content, $name, $username)){
            print "sequence saved";
        } else {
            print "there was an error saving the current sequence";
        }
    }  
}

function getSequences($username){
    $sequence = new Sequence();
    $loops = $sequence->getSequences($username);
    print(json_encode($loops));
}

function loadSequence(){
    $sequence = new Sequence();

}
