<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = new UserController();

    if (isset($_POST["login"])) {
        $user->login();
    }
    if (isset($_POST["logout"])) {
        $user->logout();
    }
    if (isset($_POST["register"])) {
        $user->registro();
    }
}

class UserController {
    public $email;
    public $usuario;
    public $pass;
    public $pass2;
    public $rol;

    public function registro() {
        $this->email = $_POST['email'];
        $this->usuario = $_POST['username'];
        $this->pass = $_POST['password'];
        $this->pass2 = $_POST['repeat-password'];
        $this->rol = $_POST['role'];

        if ($this->pass !== $this->pass2) {
            echo "Error: Las contraseñas no coinciden.";
        } else {
            if ($this->rol === "Cliente") {
                header("Location: ../View/Index_Cliente.html");
                exit();
            } else if ($this->rol === "Promotor") {
                header("Location: ../View/Index_Promotor.html");
                exit();
            } else {
                echo "Error: Rol no reconocido.";
            }
        }
    }

    public function login() {
        $this->usuario = $_POST['usuario'];
        $this->pass = $_POST['password'];
        $this->rol = $_POST['role'];

        if ($this->rol === "Cliente") {
            header("Location: ../View/Index_Cliente.html");
            exit();
        } else if ($this->rol === "Promotor") {
            header("Location: ../View/Index_Promotor.html");
            exit();
        } else {
            echo "Usuario o rol no existe";
        }
    }

    public function logout() {
        session_destroy();
        header("Location: ../View/index.html");
        exit();
    }
}
?>