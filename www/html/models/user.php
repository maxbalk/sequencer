<?php

class User extends Model {

    public function handleLogout(){
        $_SESSION = array();
        session_destroy();
    }

    public function handleLogin(){
       // var_dump($this->pdo);
        $username = empty($_POST['username']) ? '' : $_POST['username'];
        $password = empty($_POST['password']) ? '' : $_POST['password'];
        if($this->authUser($username, $password)){
            $_SESSION['loggedin'] = $username;
            header("Location: /?route=home");
        } else {
            header("Location: /?route=loginPage&error=incorrect");
        }
    }

    private function authUser($user, $pass){
        $pass = sha1($pass);
        $result = $this->qGetUser($user, $pass);
        if($result){
            return true;
        } else { 
            return false;
        }
    }

    private function qGetUser($user, $pass){
        $query = $this->pdo->prepare(
            "SELECT username, pass
             FROM appusers a
             WHERE username = ?
             AND pass = ?"
        );
        $query->execute([$user, $pass]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }


    //used these during developement to create test user with hashed password
    public function createUser($user, $pass){
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        $result = $this->qCreateUser($user, $pass);
        if($result){
            header("Location: /");
        }
    }
    private function qCreateUser($user, $pass){
        $query = $this->pdo->prepare(
            "INSERT INTO appusers (username, pass)
             VALUES (?, ?)"
        );
        return $query->execute([$user, $pass]);
    }

}