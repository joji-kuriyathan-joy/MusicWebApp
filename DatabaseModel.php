<!-- Database Connection -->

<?php
class Database {
    private $_host = 'localhost';
    private $_dbName = 'music_webapp';
    private $_userName = 'root';
    private $_password = '';
    private $_conn = null;


    private function connection() {
        if ($this->_conn === null) {
            try {
               
                $this->_conn = new PDO(
                    "mysql:host={$this->_host};dbname={$this->_dbName};charset=utf8mb4",
                    $this->_userName,
                    $this->_password
                );
                $this->_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
            } catch (PDOException $e) {
                error_log("Database connection failed: " . $e->getMessage());
                throw new Exception("Database connection failed.");
            }
        }
    }

    public function getConnection() {
        if ($this->_conn === null) {
            $this->connection();
        }
        return $this->_conn;
    }

    public function closeConnection() {
        $this->_conn = null;
    }
}

