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

}