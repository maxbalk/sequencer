<?php

class User extends Model{
    public function handleLogin(){
        $username = empty($_POST['username']) ? '' : $_POST['username'];
        $password = empty($_POST['password']) ? '' : $_POST['password'];
    }
}