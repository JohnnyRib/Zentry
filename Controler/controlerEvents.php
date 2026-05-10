<?php

class EventController {





/*=========================================================
    R. Metodo de Lectura Registros de Eventos 
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

