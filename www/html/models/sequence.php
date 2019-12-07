<?php

class Sequence extends Model {

    public function saveSequence($sequence, $name, $user){
        return $this->qSaveSequence($sequence, $name, $user);
    }

    private function qSaveSequence($s, $n , $u){
        $query = $this->pdo->prepare(
            "INSERT INTO loops (rhythms, loopname, username)
             VALUES (?, ?, ?)"
        );
        return $query->execute([$s, $n, $u]);
    }

    public function getSequences($user){
        return $this->qGetSequences($user);
    }

    private function qGetSequences($u){
        $query = $this->pdo->prepare(
            "SELECT loopname
             FROM loops
             WHERE username = ?"
        );
        $query->execute([$u]);
        $names = array();
        while($results = $query->fetch(PDO::FETCH_ASSOC)){
            array_push($names, $results);
        }
        return $names;
    }

    public function loadSequence($user, $name){
        return $this->qLoadSequence($user, $name);
    }

    private function qLoadSequence($u, $n){
        $query = $this->pdo->prepare(
            "SELECT rhythms
             FROM loops
             WHERE username = ?
             AND loopname = ?"
        );
        $query->execute([$u, $n]);
        $results = $query->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

}