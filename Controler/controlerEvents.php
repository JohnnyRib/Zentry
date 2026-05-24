<?php
class controlerEvents
{
    private $pdo;

    
    public function __construct()
    {
        $host = 'localhost';
        $db   = 'zentry';
        $user = 'root';
        $pass = '';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        try {
            $this->pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (\PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

   
    public function crear($titulo, $descripcion, $fecha, $ubicacion)
    {
        $sql = "INSERT INTO eventos (titulo, descripcion, fecha, ubicacion) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titulo, $descripcion, $fecha, $ubicacion]);
    }

    public function leerTodos()
    {
        $stmt = $this->pdo->query("SELECT * FROM eventos ORDER BY fecha ASC");
        return $stmt->fetchAll();
    }

    public function leerPorId($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM eventos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    
    public function actualizar($id, $titulo, $descripcion, $fecha, $ubicacion)
    {
        $sql = "UPDATE eventos SET titulo = ?, descripcion = ?, fecha = ?, ubicacion = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$titulo, $descripcion, $fecha, $ubicacion, $id]);
    }

    
    public function eliminar($id)
    {
        $sql = "DELETE FROM eventos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["crear_evento"])) {
    $controller = new controlerEvents();

    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $ubicacion = $_POST["ubicacion"];

    if ($controller->crear($titulo, $descripcion, $fecha, $ubicacion)) {
        header("Location: ../View/listado-evento.html");
        exit();
    } else {
        echo "Error: No se pudo crear el evento.";
    }
}