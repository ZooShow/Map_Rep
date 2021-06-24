<?php
    class User{
        public $id;
        public $login;
        public $password;

        public function __construct($id, $login, $password){
            $this->id = $id;
            $this->login = $login;
            $this->password = $password;
        }

    }

?>