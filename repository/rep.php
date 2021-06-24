<?php

    interface Repository{
        public function save($user);
        public function remove($user);
        public function getById($id);
        public function all();
        public function getByLogin($login);
    }

    class MySQLRepository implements Repository{
        private $db;

        public function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function save($user){
            $query = "SELECT * FROM USER WHERE USER_ID = $user->id";
            $usr = $this->pdo->query($query);
    
            $a = 0;
    
            while ($row = $usr->fetch(PDO::FETCH_ASSOC)) {
                $a++;
            }
    
            if ($a == 1){
                $query = "UPDATE USER SET PASSWORD = " . "'$user->password', LOGGIN = " . "'$user->login'" . " WHERE USER_ID = $user->id";
                $this->pdo->exec($query);
            } else {
                $query = "INSERT INTO USER (USER_ID, PASSWORD, LOGGIN) VALUES ($user->id, " . "'$user->password', ". "'$user->login'".");";
                $this->pdo->exec($query);
            }
        }

        public function remove($user){
            $query = "DELETE FROM USER WHERE USER_ID = $user->id;";
            $this->pdo->exec($query);
        }

        public function getById($id){
            $query = "SELECT * FROM USER WHERE USER_ID = $id";
            $usr = $this->pdo->query($query);
            $array = $usr->fetch(PDO::FETCH_ASSOC);
            $user = new User($array['USER_ID'], $array['LOGGIN'], $array['PASSWORD']);
            return $user;
        }

        public function all(){
            $query = "SELECT * FROM USER";
            $usrs = $this->pdo->query($query);
            $users = array();
            while ($usr = $usrs->fetch(PDO::FETCH_ASSOC)){
                $users[] = array('USER_ID'=>$usr['USER_ID'], 'LOGGIN'=>$usr['LOGGIN'], 'PASSWORD'=>$usr['PASSWORD']);
            }
            return($users);
        }

        public function getByLogin($login){
            $query = "SELECT * FROM USER WHERE LOGGIN = " . "'$LOGGIN';";
            $usr = $this->pdo->query($query);
            $array = $usr->fetch(PDO::FETCH_ASSOC);
            $user = new User($array['USER_ID'], $array['LOGGIN'], $array['PASSWORD']);
            return $user;
        }
    }



?>