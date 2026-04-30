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
}

class UserController
{
    public $email;
    public $usuario;
    public $pass;
    public $pass2;
    public $rol;
    public $conexion;




    /*====================================================================================================
Conexión a la base de datos utilizando PDO para una gestión más segura y eficiente de las consultas.
=====================================================================================================*/

    public function __construct()
    {
        $host = "localhost";
        $usuario = "Zentry_team";
        $password = "Zentry687";
        $base_datos = "zentry";

        try {
            //DNS
            $dns = "mysql:host=$host;dbname=$base_datos;charset=utf8mb4";

            $opciones = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->conexion = new PDO($dns, $usuario, $password, $opciones);
            echo "Conexión exitosa";
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /*=============================================================================== 
Metodos de registro, login y logout para gestionar la autenticación de usuarios, 
con validaciones básicas y redirecciones según el rol del usuario.
===============================================================================*/


    //Registro de usuarios con validación de contraseñas y asignación de roles.
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

        try {
            // Usamos la tabla 'user' y los campos de tu lógica original
            $sql = "INSERT INTO `user` (email, username, password, repeat_password, role) 
                    VALUES (:email, :username, :password, :repeat_password, :role)";

            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([
                ':email'           => $this->email,
                ':username'        => $this->usuario,
                ':password'        => $this->pass,
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
    //Login de usuarios con verificación de credenciales y redirección según el rol.
    public function login()
    {
        $this->usuario = $_POST['usuario'];
        $this->pass = $_POST['password'];

        try {

            $sql = "SELECT email, password, role FROM `user` WHERE email = :email";
            $stmt = $this->conexion->prepare($sql);

            $stmt->execute([':email' => $this->usuario]);

            if ($fila = $stmt->fetch()) {
                // Verificación de contraseña
                if ($this->pass === $fila['password']) {
                    $_SESSION['user_email'] = $fila['email'];
                    $_SESSION['user_role'] = $fila['role'];

                    // Redirección según el rol
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


    //Logout de usuarios destruyendo la sesión y redirigiendo al inicio.
    public function logout()
    {
        session_destroy();
        header("Location: ../View/index.html");
        exit();
    }
}
