<?php
    class Connection {
        private $host = "localhost";
        private $port = "3306";
        private $dbname = "db_alphacode";
        private $user = "root";
        private $password = "11031004";

        public function dbConnection () {
            try {
                $url = "mysql:host={$this->host}:{$this->port};dbname={$this->dbname}";
                $pdo = new PDO($url, $this->user, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $pdo;
            } catch(Exception $err) {
                echo "Connection Failed: {$err->getMessage()}";
            };
        }
    }
?>