<?php

class User extends Model{

    public function handleLogin(){
        var_dump($this->pdo);
        $username = empty($_POST['username']) ? '' : $_POST['username'];
        $password = empty($_POST['password']) ? '' : $_POST['password'];
        if(authUser($username, $password)){

        }
    }

    protected function authUser($user, $pass){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $result = qGetUser($user, $pass);
        if($result){
            var_dump($result);
        }

    }

    protected function qGetUser($user, $pass){
        $query = $this->pdo->prepare(
            "SELECT username, pass
             FROM appusers a
             WHERE username = ? 
             AND pass = ?"
        );
        return $query->execute($user, $pass);
    }

    public function createUser($user, $pass){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $result = $this->qCreateUser($user, $pass);
        if($result){}
    }

    private function qCreateUser($user, $pass){
        $query = $this->pdo->prepare(
            "INSERT INTO appusers (username, pass)
             VALUES (?, ?)"
        );
        return $query->execute([$user, $pass]);
    }




}