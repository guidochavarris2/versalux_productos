<?php
// Conexión a la base de datos
$servername = "btt91cnwqfbklumr7jys-mysql.services.clever-cloud.com";
$username = "unmow5zflpchxnkp";
$password = "4QoRrcODzwEB4gJaOhYf";
$dbname = "btt91cnwqfbklumr7jys";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para eliminar un producto
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM productos WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado con éxito";
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
}

// Función para actualizar un producto
if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $codigo_producto = $_POST['codigo_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $costo_sin_igv = $_POST['costo_sin_igv'];
    $marca = $_POST['marca'];

    $sql = "UPDATE productos SET codigo_producto='$codigo_producto', descripcion_producto='$descripcion_producto', costo_sin_igv='$costo_sin_igv', marca='$marca' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Producto actualizado con éxito";
    } else {
        echo "Error al actualizar el producto: " . $conn->error;
    }
}

// Obtener los datos de la base de datos
$sql = "SELECT id, codigo_producto, descripcion_producto, costo_sin_igv, marca FROM productos";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .container {
            display: flex;
            justify-content: space-around;
            width: 80%;
            margin-top: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            color: #dc3545;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div>
            <h1>Registrar Producto</h1>
            <form action="guardar_producto.php" method="post">
                <label for="codigo_producto">Código del Producto:</label>
                <input type="text" id="codigo_producto" name="codigo_producto" required>

                <label for="descripcion_producto">Descripción del Producto:</label>
                <textarea id="descripcion_producto" name="descripcion_producto" required></textarea>

                <label for="costo_sin_igv">Costo del Producto sin IGV:</label>
                <input type="number" step="0.01" id="costo_sin_igv" name="costo_sin_igv" required>

                <label for="marca">Marca:</label>
                <input type="text" id="marca" name="marca" required>

                <input type="submit" value="Guardar Producto">
            </form>
            <br>
            
            <a  href="mostrar_productos_con_dolar.php"><input style="background-color: blue" type="submit" value="PRODUCTOS EN DOLAR"></a>
        </div>

        <div>
            <h1>Lista de Productos</h1>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Código del Producto</th>
                    <th>Descripción del Producto</th>
                    <th>Costo sin IGV</th>
                    <th>Marca</th>
                    <th>Acciones</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    // Mostrar datos de cada fila
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<form method='post'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td><input type='text' name='codigo_producto' value='" . $row['codigo_producto'] . "'></td>";
                        echo "<td><input type='text' name='descripcion_producto' value='" . $row['descripcion_producto'] . "'></td>";
                        echo "<td><input type='text' name='costo_sin_igv' value='" . $row['costo_sin_igv'] . "'></td>";
                        echo "<td><input type='text' name='marca' value='" . $row['marca'] . "'></td>";
                        echo "<td class='actions'><input type='submit' name='update' value='Actualizar'> | <a href='?delete=" . $row['id'] . "'>Eliminar</a></td>";
                        echo "</form>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
                }
                $conn->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
