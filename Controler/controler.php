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

    /*
    Conexion PDO
    try{
        //DNS
        $dns = mysql:host=$host;dbname=$base_datos;charset=utf8mb4;

        $opciones =[
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES =>
        ];
        $pdo = new PDO($dsn, $usuario, $password, $opciones);
        echo "Conexión exitosa";
    } catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
    }
    */



    $this->conexion = new mysqli($host, $usuario, $password, $base_datos);

    if ($this->conexion->connect_error) {
        die("Error de conexión: " . $this->conexion->connect_error);
    }

    $this->conexion->set_charset("utf8mb4");
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

    $sql = "INSERT INTO `user` (email, username, password, repeat_password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conexion->prepare($sql);

    if (!$stmt) {
        die("Error en prepare: " . $this->conexion->error);
    }

    $stmt->bind_param("ssssi", $this->email, $this->usuario, $this->pass, $this->pass2, $this->rol);

    if ($stmt->execute()) {
        if ($this->rol === 1) {
            header("Location: ../View/Index_Promotor.html");
        } else {
            header("Location: ../View/Index_Cliente.html");
        }
        exit();
    } else {
        echo "Error al registrar: " . $stmt->error;
    }

    $stmt->close();
    $this->conexion->close();
}

    public function login()
{
    $this->usuario = $_POST['usuario'];
    $this->pass = $_POST['password'];

    $sql = "SELECT email, password, role FROM `user` WHERE email = ?";
    $stmt = $this->conexion->prepare($sql);

    if (!$stmt) {
        die("Error en prepare: " . $this->conexion->error);
    }

    $stmt->bind_param("s", $this->usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        if ($this->pass === $fila['password']) {
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

    $stmt->close();
    $this->conexion->close();
}

    public function logout()
    {
        session_destroy();
        header("Location: ../View/index.html");
        exit();
    }
}
