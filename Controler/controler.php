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
        $base_datos = "Zentry";

        // Crear conexión
        $this->conexion = new mysqli($host, $usuario, $password, $base_datos);

        // Verificar conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        echo "Conexión exitosa";

        // Establecer charset UTF-8
        $this->conexion->set_charset("utf8mb4");
    }


    public function registro()
    {
        echo "en register";
        $this->email = $_POST['email'];
        $this->usuario = $_POST['username'];
        $this->pass = $_POST['password'];
        $this->pass2 = $_POST['repeat-password'];
        $this->rol = $_POST['role'];

    
        $this->rol = ($_POST['role'] === "Promotor") ? 1 : 0;
        $sql = "INSERT INTO User (email, username, password, repeat_password, role) VALUE (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($sql);



        $stmt->bind_param("ssssi", $this->email, $this->usuario, $this->pass, $this->pass2, $this->rol);

        if ($stmt->execute()) {
            echo "Registro insertado correctamente<br>";
            echo "ID del nuevo registro: " . $this->conexion->insert_id;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $this->conexion->close();

        // gestionar error

    }

    public function login()
    {
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



        // Ejecutar consulta
        $sql = "SELECT  email FROM User WHERE email = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        // Verificar si hay resultados
        if ($resultado->num_rows > 0) {
            // Recorrer resultados
            while ($fila = $resultado->fetch_assoc()) {
                echo "ID: " . $fila['id'] . " - ";
                echo "Nombre: " . $fila['nombre'] . " - ";
                echo "Email: " . $fila['email'] . "<br>";
            }
        } else {
            echo "No se encontraron resultados";
        }

        // Liberar resultado
        $resultado->free();
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