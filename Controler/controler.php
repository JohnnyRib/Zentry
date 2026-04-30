<?php

/*=========================================
Inicio de sesión y control de acceso para el login, registro y logout de usuarios.
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

/*==================================================================================================
Propiedades para la gestión de usuarios, incluyendo campos como email, username, 
password, repeat_password y role para almacenar la información de los usuarios registrados.
===================================================================================================*/
    public $email;
    public $usuario;
    public $pass;
    public $pass2;
    public $rol;
    public $conexion;
    

/*================================================================================================== 
Propiedades para la gestión de eventos, incluyendo campos como event_id, event_name, event_category, 
event_date, event_time, event_location,event_description, event_image, event_audio y event_video.
===================================================================================================*/
    public $event_id;
    public $event_name;
    public $event_category; 
    public $event_date;
    public $event_time;
    public $event_location;
    public $event_description;
    public $event_image;
    public $event_audio;
    public $event_video;
    


/*====================================================================================================
Conexión a la base de datos utilizando PDO para una gestión más segura y eficiente de las consultas.
=====================================================================================================*/

    public function __construct()
{
    $host = "localhost";
    $usuario = "Zentry_team";
    $password = "Zentry687";
    $base_datos = "zentry";



    // Establecer conexión con PDO

/*Concción con la base de Datos*/

    try{
        //DNS
        $dns = "mysql:host=$host;dbname=$base_datos;charset=utf8mb4";

        $opciones =[
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

    $sql = "INSERT INTO `user` (email, username, password, repeat_password, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->conexion->prepare($sql);

    try {
    $pdo = new PDO("mysql:host=localhost;dbname=Zentry", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "INSERT INTO usuarios (nombre, email, edad) VALUES (:nombre, :email, :edad)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->execute([
        ':nombre' => 'Pedro Martínez',
        ':email' => 'pedro@ejemplo.com',
        ':edad' => 35
    ]);
    
    echo "Registro insertado correctamente<br>";
    echo "ID del nuevo registro: " . $pdo->lastInsertId();
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

}

//Login de usuarios con verificación de credenciales y redirección según el rol.
    public function login()
{
    $this->usuario = $_POST['usuario'];
    $this->pass = $_POST['password'];

    $sql = "SELECT email, password, role FROM `user` WHERE email = ?";
    $stmt = $this->conexion->prepare($sql);

if (!$stmt) {
    die("Error en prepare.");
}

$stmt->execute([$this->usuario]);

$fila = $stmt->fetch(PDO::FETCH_ASSOC);

if ($fila) {
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

// En PDO no se usa close()
$stmt = null;
$this->conexion = null;
}


//Logout de usuarios destruyendo la sesión y redirigiendo al inicio.
    public function logout()
    {
        session_destroy();
        header("Location: ../View/index.html");
        exit();
    }

/*=========================================================
Metodo de Lectura Registros de Eventos 
==========================================================*/
    public function leerEventos()
    {
    
    try {
    $pdo = new PDO("mysql:host=localhost;dbname=Zentry", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Ejecutar consulta
    $sql = "SELECT event_name, event_category, event_date FROM Events";
    $stmt = $pdo->query($sql);
    
    // Recorrer resultados
    while ($fila = $stmt->fetch()) {
        echo "Nombre: " . $fila['event_name'] . " - ";
        echo "Categoría: " . $fila['event_category'] . " - ";
        echo "Fecha: " . $fila['event_date'] . "<br>";
    }
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}    

    }
}
