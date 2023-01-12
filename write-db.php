<?php

$temperatura = $_GET['temp'];
$humedad = $_GET['hum'];

echo "La temperatura es:" .$temperatura. "<br>La humedad es: " .$humedad;
$usuario = "root";
$contraseña = "";
$servidor = "localhost";
$database = "incubit";

$conexion = mysqli_connect($servidor, $usuario, $contraseña) or die ("No se puede conectar a la base de datos");
$db = mysqli_select_db($conexion, $database) or die ("No se puede seleccionar la base de datos");


$consulta = "INSERT INTO medicion(fecha, hora, temperatura, humedad) VALUES (CURDATE(), CURTIME(), ".$temperatura.", ".$humedad.")";
$resultado = mysqli_query($conexion, $consulta);

?>