<?php

/*=========================================
Control de eventos para crear, leer,
actualizar y eliminar eventos.
=========================================*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event = new controlerEvents();

    if (isset($_POST["crear_evento"])) {
        $event->crearEvento();
    }
}

class controlerEvents
{
    // Conexión con la base de datos
    private $pdo;

    /*=========================================
    Constructor de la clase.
    Se encarga de conectar con la base de datos.
    =========================================*/
    public function __construct()
    {
        $host = "localhost";
        $db = "zentry";
        $user = "Zentry_team";
        $pass = "Zentry687";
        $charset = "utf8mb4";

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    /*=========================================
    Método para crear un nuevo evento.
    Recibe los datos del formulario y los guarda
    en la tabla eventos de la base de datos.
    =========================================*/
    public function crearEvento()
    {
        $titulo = trim($_POST["titulo"]);
        $descripcion = trim($_POST["descripcion"]);
        $fecha = $_POST["fecha"];
        $ubicacion = trim($_POST["ubicacion"]);

        // Validación de campos obligatorios
        if (empty($titulo) || empty($descripcion) || empty($fecha) || empty($ubicacion)) {
            die("Error: debes completar todos los campos obligatorios.");
        }

        try {
            $sql = "INSERT INTO eventos (titulo, descripcion, fecha, ubicacion) 
                    VALUES (:titulo, :descripcion, :fecha, :ubicacion)";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ":titulo" => $titulo,
                ":descripcion" => $descripcion,
                ":fecha" => $fecha,
                ":ubicacion" => $ubicacion
            ]);

            header("Location: ../View/listado-evento.html");
            exit();

        } catch (PDOException $e) {
            echo "Error al crear evento: " . $e->getMessage();
        }
    }

    /*=========================================
    Método para leer todos los eventos.
    Devuelve todos los registros ordenados por fecha.
    =========================================*/
    public function leerTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM eventos ORDER BY fecha ASC");
        return $stmt->fetchAll();
    }

    /*=========================================
    Método para leer un evento específico.
    Busca un evento según su ID.
    =========================================*/
    public function leerPorId($id)
    {
        $sql = "SELECT * FROM eventos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([":id" => $id]);
        return $stmt->fetch();
    }

    /*=========================================
    Método para actualizar un evento.
    Modifica los datos de un evento existente
    según su ID.
    =========================================*/
    public function actualizar($id, $titulo, $descripcion, $fecha, $ubicacion)
    {
        $sql = "UPDATE eventos 
                SET titulo = :titulo, descripcion = :descripcion, fecha = :fecha, ubicacion = :ubicacion 
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ":titulo" => $titulo,
            ":descripcion" => $descripcion,
            ":fecha" => $fecha,
            ":ubicacion" => $ubicacion,
            ":id" => $id
        ]);
    }

    /*=========================================
    Método para eliminar un evento.
    Borra un evento de la base de datos según su ID.
    =========================================*/
    public function eliminar($id)
    {
        $sql = "DELETE FROM eventos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([":id" => $id]);
    }
}