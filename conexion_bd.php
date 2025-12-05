<?php
$host = 'localhost';
$usuario='root';
$contrasena='Grupo4DS';
$baseDeDatos='bdsharmely'; 
$dsn = "mysql:host=$host;dbname=$baseDeDatos;charset=utf8mb4";

$conexion=new mysqli($host,$usuario,$contrasena,$baseDeDatos);
if($conexion->connect_error){
	die('Error p soli'); //try catch
	}
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // lanzar excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false, // usar prepares nativos
];

try {
    $pdo = new PDO($dsn, $usuario, $contrasena, $options);
} catch (PDOException $e) {
    // En producción: no mostrar detalles al usuario. Guardar en logs.
    error_log("DB connection error: " . $e->getMessage());
    // Mostrar un mensaje genérico si es necesario:
    die("Error de conexión con la base de datos.");
}

?>



