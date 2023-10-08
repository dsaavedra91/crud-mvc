<?php
require_once 'config/database.php';

$database = new Database();
$dbConnection = $database->getConnection();

$response = array();
$message = "";

try {
    $sqlCreateDb = "CREATE DATABASE IF NOT EXISTS " . $database->getDbName();
    $dbConnection->exec($sqlCreateDb);
    $message .= "Base de datos creada exitosamente.<br>";

    $dbConnection = $database->getConnection();

    $sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(50) NOT NULL,
        last_name VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    )";
    $dbConnection->exec($sqlCreateTable);
    $message .= "Tabla de usuarios creada exitosamente.<br>";
    $response['success'] = true;
} catch (PDOException $e) {
    $message = "Error al crear base de datos y tabla: " . $e->getMessage();
    $response['success'] = false;
}

$dbConnection = null;

$response['message'] = $message;
echo json_encode($response);
exit();
?>
