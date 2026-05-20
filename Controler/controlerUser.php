<?php

/*=========================================
Inicio de sesión y control de acceso para el login, 
registro y logout de usuarios.
=========================================*/



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
    if (isset($_POST["update_user"])) {
        $user->updateUser();
    }
    if (isset($_POST["delete_account"])) {
        $user->deleteUser();
    }
    if (isset($_POST["change_password"])) {
        $user->UpdatePassword();
    }
}

class UserController
{
    public $email;
    public $usuario;
    public $pass;
    public $pass2;
    public $rol;
    public $conexion;

    public function __construct()
    {
        $host = "localhost";
        $usuario = "Zentry_team";
        $password = "Zentry687";
        $base_datos = "zentry";

        try {
            $dns = "mysql:host=$host;dbname=$base_datos;charset=utf8mb4";
            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->conexion = new PDO($dns, $usuario, $password, $opciones);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    public function registro()
    {
        $this->email = trim($_POST['email']);
        $this->usuario = trim($_POST['username']);
        $this->pass = $_POST['password'];
        $this->pass2 = $_POST['repeat-password'];
        $this->rol = ($_POST['role'] === "Promotor") ? 1 : 0;

        if ($this->pass !== $this->pass2) {
            die("Error: las contraseñas no coinciden.");
        }
        if (strlen($this->pass) < 8) {
            die("Error: La contraseña debe tener al menos 8 caracteres.");
        }

        // Requerimiento 3.5: Hash de contraseña
        $passwordHasheada = password_hash($this->pass, PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO `user` (email, username, password, repeat_password, role) 
                    VALUES (:email, :username, :password, :repeat_password, :role)";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':email'           => $this->email,
                ':username'        => $this->usuario,
                ':password'        => $passwordHasheada,
                ':repeat_password' => $this->pass2,
                ':role'            => $this->rol
            ]);

            if ($this->rol === 1) {
                header("Location: ../View/Index_Promotor.html");
            } else {
                header("Location: ../View/Index_Cliente.html");
            }
            exit();
        } catch (PDOException $e) {
            echo "Error al registrar: " . $e->getMessage();
        }
    }

    //3.6 verificacion de contraseña mediante hash.
    public function login()
    {
        $this->usuario = $_POST['usuario'];
        $this->pass = $_POST['password'];

        try {
            // Requerimiento 3.6: Verificación con password_verify
            $sql = "SELECT email, password, role FROM `user` WHERE email = :email";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([':email' => $this->usuario]);

            if ($fila = $stmt->fetch()) {
                if (password_verify($this->pass, $fila['password'])) {
                    $_SESSION['user_email'] = $fila['email'];
                    $_SESSION['user_role'] = $fila['role'];

                    if ((int)$fila['role'] === 1) {
                        header("Location: ../View/Index_Promotor.html");
                    } else {
                        header("Location: ../View/Index_Cliente.html");
                    }
                    exit();
                } else {
                    echo "Error: Contraseña incorrecta.";
                }
            } else {
                echo "Error: Usuario no encontrado.";
            }
        } catch (PDOException $e) {
            echo "Error en el login: " . $e->getMessage();
        }
    }

    public function updateUser()
    {
        if (!isset($_SESSION['user_email'])) {
            die("Error: No hay una sesión activa.");
        }

        $emailActual = $_SESSION['user_email'];
        $nuevoUsername = trim($_POST['username']);
        $nuevoEmail = trim($_POST['email']);

        try {
            $sql = "UPDATE `user` SET username = :username, email = :email WHERE email = :email_actual";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([
                ':username'     => $nuevoUsername,
                ':email'        => $nuevoEmail,
                ':email_actual' => $emailActual
            ]);

            $_SESSION['user_email'] = $nuevoEmail;
            echo "Datos actualizados correctamente.";
        } catch (PDOException $e) {
            echo "Error al actualizar los datos: " . $e->getMessage();
        }
    }

    public function UpdatePassword()
    {
        if (!isset($_SESSION['user_email'])) {
            die("Error: No hay una sesión activa.");
        }

        $emailUsuario = $_SESSION['user_email'];
        $passActual = $_POST['current_password'];
        $nuevaPass = $_POST['new_password'];
        $confirmarPass = $_POST['confirm_password'];

        if ($nuevaPass !== $confirmarPass) {
            die("Error: La nueva contraseña y su confirmación no coinciden.");
        }

        try {
            $sqlVerificar = "SELECT password FROM `user` WHERE email = :email";
            $stmtVerificar = $this->conexion->prepare($sqlVerificar);
            $stmtVerificar->execute([':email' => $emailUsuario]);
            $usuario = $stmtVerificar->fetch();

            if ($usuario && password_verify($passActual, $usuario['password'])) {
                $nuevaPassHasheada = password_hash($nuevaPass, PASSWORD_DEFAULT);
                $sqlUpdate = "UPDATE `user` SET password = :password, repeat_password = :repeat_password WHERE email = :email";
                $stmtUpdate = $this->conexion->prepare($sqlUpdate);
                $stmtUpdate->execute([
                    ':password'        => $nuevaPassHasheada,
                    ':repeat_password' => $nuevaPassHasheada,
                    ':email'           => $emailUsuario
                ]);
                echo "Contraseña actualizada con éxito.";
            } else {
                echo "Error: La contraseña actual es incorrecta.";
            }
        } catch (PDOException $e) {
            echo "Error al actualizar la contraseña: " . $e->getMessage();
        }
    }

    public function deleteUser()
    {
        if (!isset($_SESSION['user_email'])) {
            die("Error: No se encontró una sesión activa.");
        }
        $emailUsuario = $_SESSION['user_email'];
        try {
            $sql = "DELETE FROM `user` WHERE email = :email";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([':email' => $emailUsuario]);
            $_SESSION = [];
            session_destroy();
            header("Location: ../View/index.html");
            exit();
        } catch (PDOException $e) {
            echo "Error al procesar la baja: " . $e->getMessage();
        }
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        header("Location: ../View/index.html");
        exit();
    }
}
