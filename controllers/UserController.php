<?php
require_once getcwd().'/models/UserModel.php';
require_once getcwd().'/helpers/ViewLoader.php';

class UserController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new UserModel($db);
        ViewLoader::initialize();
    }

    public function indexPage() {
        $this->checkSession();
        $users = $this->userModel->listUsers();
        $data = array('title' => 'Listado de usuarios', 'users' => $users);
        ViewLoader::loadView("users", $data);
    }

    public function loginPage() {
        if (isset($_SESSION['user_id'])) {
            header("Location: users");
            exit();
        }
        $data = array('title' => 'Login');
        ViewLoader::loadView("login", $data);
    }

    public function registerPage() {
        if (isset($_SESSION['user_id'])) {
            header("Location: adduser");
            exit();
        }        
        $data = array('title' => 'Registrarse', 'page' => 'register');
        ViewLoader::loadView("register", $data);
    }

    public function addUserPage() {
        $this->checkSession();
        $data = array('title' => 'Agregar usuario', 'page' => 'add');
        ViewLoader::loadView("register", $data);
    }

    public function editUserPage($id) {
        $this->checkSession();
        $user = $this->userModel->getUserById($id);
        ViewLoader::loadView("register", array('title' => 'Actualizar usuario', 'page' => 'update', 'user' => $user));
    }

    public function errorPage($message) {
        $data = array('title' => 'Error', 'message' => $message);
        ViewLoader::loadView("error", $data);
    }

    public function insertUser() {
        $result = array();
        $jsonData = file_get_contents("php://input");
        $user = json_decode($jsonData, true);

        $isValid = $this->validateUserData($user);

        if ($isValid === true) {
            $hashedPassword = password_hash($user['password'], PASSWORD_BCRYPT);
            $userAdded = $this->userModel->addUser($user['first_name'], $user['last_name'], $user['email'], $hashedPassword);

            if ($userAdded) {
                $result['success'] = true;
            } else {
                $result['success'] = false;
                $result['message'] = "Hubo un error al registrar la cuenta. Por favor, inténtalo nuevamente.";
            }
        } else {
            $result['success'] = false;
            $result['message'] = $isValid;
        }
        echo json_encode($result);
        exit();
    }

    public function loginUser() {
        $result = array();
        $jsonData = file_get_contents("php://input");
        $user = json_decode($jsonData, true);

        if (empty($user['email']) || empty($user['password'])) {
            $result['success'] = false;
            $result['message'] = "Por favor ingrese correo electrónico y contraseña";
        } else {
            $existingUser = $this->userModel->getUserByEmail($user['email']);

            if ($existingUser) {
                $userId = $existingUser["id"];
                $hashedPassword = $existingUser["password"];

                if (password_verify($user['password'], $hashedPassword)) {
                    $_SESSION["user_id"] = $userId;
                    $result['success'] = true;
                } else {
                    $result['success'] = false;
                    $result['message'] = "Verifique los datos ingresados.";
                }
            } else {
                $result['success'] = false;
                $result['message'] = "Verifique los datos ingresados.";
            }
        }
        echo json_encode($result);
        exit();
    }

    public function logoutUser() {
        session_destroy();
        header("Location: login");
        exit();
    }

    public function updateUser() {
        $result = array();
        $userID = null;
        $jsonData = file_get_contents("php://input");
        $user = json_decode($jsonData, true);

        $updateData = array();

        if (!empty($user['first_name'])) {
            $updateData['first_name'] = $user['first_name'];
        }
        if (!empty($user['last_name'])) {
            $updateData['last_name'] = $user['last_name'];
        }
        if (!empty($user['email'])) {
            $updateData['email'] = $user['email'];
        }
        if (!empty($user['password'])) {
            $updateData['password'] = password_hash($user['password'], PASSWORD_BCRYPT);
        }
        if (!empty($user['id'])) {
            $userID = $user['id'];
            unset($user['id']);
        }

        if (!empty($updateData) && $userID > 0) {
            $userUpdated = $this->userModel->updateUser($userID, $updateData);
            $result['success'] = $userUpdated;
            $result['message'] = "Se produjo un error, inténtalo de nuevo más tarde.";
        } else {
            $result['success'] = false;
            $result['message'] = "Debes completar al menos un campo.";
        }
        echo json_encode($result);
        exit();
    }

    public function deleteUser() {
        $this->checkSession();
        $jsonData = file_get_contents("php://input");
        $data = json_decode($jsonData, true);
        $this->userModel->deleteUser($data['userID']);
        echo json_encode(array('success'=> true));
        exit();
    }

    public function checkSession() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login");
            exit();
        }
    }

    private function validateUserData($user) {
        if (empty($user['first_name']) || empty($user['last_name']) || empty($user['email']) || empty($user['password'])) {
            return "Todos los campos son obligatorios.";
        }

        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
            return "Dirección de correo electrónico no válida.";
        }

        $existingUser = $this->userModel->getUserByEmail($user['email']);
        
        if ($existingUser) {
            return "El correo electrónico ya está registrado.";
        }
        return true;
    }
    function defaultRoute() {
        if (isset($_SESSION['user_id'])) {
            header("Location: users");
            exit();
        } else {
            header("Location: login");
            exit();
        }
    }    
}
?>
