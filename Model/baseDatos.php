<?php

//datos de conexción

$host= "localhost";
$usuario= "root";
$password="";
$base_datos="Zentry";

$conexion = new mysqli($host, $usuario, $password, $base_datos); 

if($conexion-> connect_error) {
    die("Error de Conexion: " . $conexion-> connect_error);

}

    echo "Conexión exitosa";

    $conexion -> set_charset("utf8mb4");
    $conexion -> close();

    //INSERT de datos de la tabla USER

    $sql = "INSERT INTO User (email, username, age, password, role) VALUE (?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    $email;
    $username;
    $age;
    $password;
    $role;

    $stmt->bind_param("ssisi", $email, $username, $age, $password, $role);

    if($stmt->execute()){
        echo "Registro insertadp correctamente<br>";
        echo "ID del nuevo registro: " .$conexion->insert_id;
    } else {
        echo "ERROR: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();

   

$sql = "UPDATE User SET username = ?, email = ?, age = ?, password = ?, WHERE id = ?";
$stmt = $conexion->prepare($sql);

$nombre; 
$email; 
$id;

$stmt->bind_param("ssisi", $nombre, $email, $id);

if ($stmt->execute()) {
    echo "Registro actualizado correctamente<br>";
    echo "Filas afectadas: " . $stmt->affected_rows;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();
    


// INSERT con prepared statement
$sql = "INSERT INTO usuarios (nombre, email, edad) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);

$nombre = "Juan Pérez";
$email = "juan@ejemplo.com";
$edad = 30;

$stmt->bind_param("ssi", $nombre, $email, $edad);

if ($stmt->execute()) {
    echo "Registro insertado correctamente<br>";
    echo "ID del nuevo registro: " . $conexion->insert_id;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();

//Update los datos de la tabla User 

$conexion = new mysqli("localhost", "root", "", "mi_base_datos");

$sql = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
$stmt = $conexion->prepare($sql);

$nombre = "María García";
$email = "maria@ejemplo.com";
$id = 5;

$stmt->bind_param("ssi", $nombre, $email, $id);

if ($stmt->execute()) {
    echo "Registro actualizado correctamente<br>";
    echo "Filas afectadas: " . $stmt->affected_rows;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();

//Delete los datos de la tabla User


$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $conexion->prepare($sql);

$id = 10;
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo "Registro eliminado correctamente";
    } else {
        echo "No se encontró el registro";
    }
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conexion->close();

?>



