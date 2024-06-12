<?php
// Conexión a la base de datos
$servername = "btt91cnwqfbklumr7jys-mysql.services.clever-cloud.com";
$username = "unmow5zflpchxnkp";
$password = "4QoRrcODzwEB4gJaOhYf";
$dbname = "btt91cnwqfbklumr7jys";


$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$codigo_producto = $_POST['codigo_producto'];
$descripcion_producto = $_POST['descripcion_producto'];
$costo_sin_igv = $_POST['costo_sin_igv'];
$marca = $_POST['marca'];
$imagen = $_POST['imagen'];

// Insertar los datos en la base de datos
$sql = "INSERT INTO productos (codigo_producto, descripcion_producto, costo_sin_igv, marca, imagen)
VALUES ('$codigo_producto', '$descripcion_producto', $costo_sin_igv, '$marca','$imagen')";

if ($conn->query($sql) === TRUE) {
    header('Location: mostrar_productos.php');
    echo "Nuevo producto registrado exitosamente<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
<br>
<a href="formulario.html">Registrar otro producto</a><br>
<a href="mostrar_productos.php">Ver Lista de Productos</a><br>
<a href="mostrar_productos_con_dolar.php">Ver Productos con Precio en Dólares</a>