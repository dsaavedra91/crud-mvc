<?php
class UserModel {
    private $db;
    private $table = "users";

    public function __construct($database) {
        $this->db = $database;
    }

    public function addUser($first_name, $lastName, $email, $password) {
        $sql = "INSERT INTO $this->table (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :password)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":first_name", $first_name);
        $stmt->bindParam(":last_name", $lastName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getUserById($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $updateData) {
        if (isset($updateData['password'])) {
            $hash = password_hash($updateData['password'], PASSWORD_BCRYPT);
            $updateData['password'] = $hash;
        }

        $sql = "UPDATE $this->table SET ";
        $filteredUpdateData = [];
        foreach ($updateData as $field => $value) {
            $filteredUpdateData[] = "$field = :$field";
        }
        $sql .= implode(', ', $filteredUpdateData);
        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        foreach ($updateData as $field => &$value) {
            $stmt->bindParam(":$field", $value);
        }
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function listUsers() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
