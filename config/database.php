<?php
require_once getcwd().'/helpers/ViewLoader.php';
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "crud_saavedra";
    
    public function __construct() {
        ViewLoader::initialize();
    }

    public function getConnection() {
        $conn = null;
        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            if ($exception->getCode() === 1049 && (strpos($_SERVER['REQUEST_URI'], 'createdb.php') == false) ) {

                $data = array(
                    'host' => $this->host,
                    'database' => $this->database,
                    'username' => $this->username,
                    'password' => $this->password, 
                    'title' => 'Error DB');
                ViewLoader::loadView("migratedb", $data);
                die();                   
            } else {
                $conn = new PDO("mysql:host=$this->host", $this->username, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
        }
        return $conn;
    }

    public function getDbName(){
        return $this->database;
    }
}
?>
