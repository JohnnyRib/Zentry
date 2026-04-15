<?php

//datos de conexción

$host= "localhost";
$usuario= "root";
$password="";
$base_datos="GameHub";

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
    
?>


