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

// Obtener el precio actual del dólar (supongamos que viene de un formulario o una API externa)
$precio_dolar = isset($_POST['precio_dolar']) ? $_POST['precio_dolar'] : 1.00;

// Obtener los datos de la base de datos
$sql = "SELECT id, codigo_producto, descripcion_producto, costo_sin_igv, marca FROM productos";
$result = $conn->query($sql);

// Función para calcular el monto adicional
function calcular_monto_adicional($costo) {
    if ($costo >= 0 && $costo <= 49) return 20;
    if ($costo >= 50 && $costo <= 99) return 25;
    if ($costo >= 100 && $costo <= 149) return 30;
    if ($costo >= 150 && $costo <= 199) return 35;
    if ($costo >= 200 && $costo <= 249) return 40;
    if ($costo >= 250 && $costo <= 299) return 45;
    if ($costo >= 300 && $costo <= 349) return 50;
    if ($costo >= 350 && $costo <= 399) return 55;
    if ($costo >= 400 && $costo <= 449) return 60;
    if ($costo >= 450 && $costo <= 499) return 65;
    if ($costo >= 500 && $costo <= 549) return 70;
    if ($costo >= 550 && $costo <= 599) return 75;
    if ($costo >= 600 && $costo <= 649) return 80;
    if ($costo >= 650 && $costo <= 699) return 85;
    if ($costo >= 700 && $costo <= 749) return 90;
    if ($costo >= 750 && $costo <= 799) return 95;
    if ($costo >= 800 && $costo <= 849) return 100;
    if ($costo >= 850 && $costo <= 899) return 105;
    if ($costo >= 900 && $costo <= 949) return 110;
    if ($costo >= 950 && $costo <= 999) return 115;

    if ($costo >= 1000 && $costo <= 1249) return 125;
    if ($costo >= 1250 && $costo <= 1499) return 150;
    if ($costo >= 1500 && $costo <= 1749) return 175;
    if ($costo >= 1750 && $costo <= 1999) return 200;
    if ($costo >= 2000 && $costo <= 2249) return 225;
    if ($costo >= 2250 && $costo <= 2499) return 250;
    if ($costo >= 2500 && $costo <= 2749) return 275;
    if ($costo >= 2750 && $costo <= 2999) return 300;
    if ($costo >= 3000 && $costo <= 3249) return 325;
    if ($costo >= 3250 && $costo <= 3499) return 350;
    if ($costo >= 3500 && $costo <= 3749) return 375;
    if ($costo >= 3750 && $costo <= 3999) return 400;
    if ($costo >= 4000 && $costo <= 4249) return 425;
    if ($costo >= 4250 && $costo <= 4499) return 450;
    if ($costo >= 4500 && $costo <= 4749) return 475;
    if ($costo >= 4750 && $costo <= 4999) return 500;
    if ($costo >= 5000 && $costo <= 5249) return 525;
    if ($costo >= 5250 && $costo <= 5499) return 550;
    if ($costo >= 5500 && $costo <= 5749) return 575;
    if ($costo >= 5750 && $costo <= 5999) return 600;
    if ($costo >= 6000 && $costo <= 6249) return 625;
    if ($costo >= 6250 && $costo <= 6499) return 650;
    if ($costo >= 6500 && $costo <= 6749) return 675;
    if ($costo >= 6750 && $costo <= 6999) return 700;
    if ($costo >= 7000 && $costo <= 7249) return 725;
    if ($costo >= 7250 && $costo <= 7499) return 750;
    if ($costo >= 7500 && $costo <= 7749) return 775;
    if ($costo >= 7750 && $costo <= 7999) return 800;
    if ($costo >= 8000 && $costo <= 8249) return 825;
    if ($costo >= 8250 && $costo <= 8499) return 850;
    if ($costo >= 8500 && $costo <= 8749) return 875;
    if ($costo >= 8750 && $costo <= 8999) return 900;
    if ($costo >= 9000 && $costo <= 9249) return 925;
    if ($costo >= 9250 && $costo <= 9499) return 950;
    if ($costo >= 9500 && $costo <= 9749) return 975;
    if ($costo >= 9750 && $costo <= 9999) return 1000;
    // Para otros valores, puedes añadir más condiciones aquí
    return 0; // Por defecto, si no cae en ninguna categoría
}
// Crear una nueva instancia de PhpSpreadsheet
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer los encabezados de la tabla en Excel
$sheet->setCellValue('A1', 'item');
$sheet->setCellValue('B1', 'Código del Producto');
$sheet->setCellValue('C1', 'Descripción del Producto');
$sheet->setCellValue('D1', 'Marca');
$sheet->setCellValue('E1', 'Costo sin IGV (S/.)');
$sheet->setCellValue('F1', 'Valor del Dólar');
$sheet->setCellValue('G1', 'Costo del Producto en Soles');
$sheet->setCellValue('H1', 'Costo IGV');
$sheet->setCellValue('I1', 'Costo Total Incluido IGV');
$sheet->setCellValue('J1', 'Monto Adicional por Venta');
$sheet->setCellValue('K1', 'Venta sin IGV');
$sheet->setCellValue('L1', 'IGV Venta');
$sheet->setCellValue('M1', 'Precio de Venta Incluido IGV');
$sheet->setCellValue('N1', 'Diferencia IGV');
$sheet->setCellValue('O1', 'Ganancia Subtotal');
$sheet->setCellValue('P1', 'Ganancia Total Restando IGV');

// Obtener los datos de la tabla y escribirlos en Excel
$rowIndex = 2; // Empieza desde la fila 2 para los datos

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calcular el costo en dólares
        $costo_dolares = $row["costo_sin_igv"] * $precio_dolar;
        // Calcular el monto adicional
        $monto_adicional = calcular_monto_adicional($costo_dolares);

        
        // Calcula los demás valores
        $costoIGV = ($costo_dolares * 0.18);
        $costo_Total_IGV = $costo_dolares + $costoIGV;
        $venta_sin_IGV = $costo_dolares + $monto_adicional;
        $IGV_venta = $venta_sin_IGV * 0.18;
        $precio_venta_IGV = $venta_sin_IGV + $IGV_venta;
        $diferenciaIGV = $costoIGV - $IGV_venta;
        $ganancia_subtotal = $precio_venta_IGV - $costo_Total_IGV;
        $ganancia_total = $ganancia_subtotal + $diferenciaIGV;

        // Otros cálculos según tus necesidades
        // ...

        // Asignar los valores de cada fila a las celdas correspondientes
        $sheet->setCellValue('A' . $rowIndex, $row["id"]);
        $sheet->setCellValue('B' . $rowIndex, $row["codigo_producto"]);
        $sheet->setCellValue('C' . $rowIndex, $row["descripcion_producto"]);
        $sheet->setCellValue('D' . $rowIndex, $row["marca"]);
        $sheet->setCellValue('E' . $rowIndex, $row["costo_sin_igv"]);
        $sheet->setCellValue('F' . $rowIndex, $precio_dolar);
        $sheet->setCellValue('G' . $rowIndex, $costo_dolares);
        $sheet->setCellValue('H' . $rowIndex, $costoIGV);
        $sheet->setCellValue('I' . $rowIndex, $costo_Total_IGV);
        $sheet->setCellValue('J' . $rowIndex, $monto_adicional);
        $sheet->setCellValue('K' . $rowIndex, $venta_sin_IGV);
        $sheet->setCellValue('L' . $rowIndex, $IGV_venta);
        $sheet->setCellValue('M' . $rowIndex, $precio_venta_IGV);
        $sheet->setCellValue('N' . $rowIndex, $diferenciaIGV);
        $sheet->setCellValue('O' . $rowIndex, $ganancia_subtotal);
        $sheet->setCellValue('P' . $rowIndex, $ganancia_total);
        // Continúa asignando los valores para las otras columnas según tu lógica
        $rowIndex++;
    }
}



// Cerrar conexión a la base de datos
$conn->close();

?>

<?php
// Datos
$token = 'apis-token-8889.V12Jb4-L-UD4at4ApsW06t0ZquupcTcz';
$fecha = '2024-06-09';

// Iniciar llamada a API
$curl = curl_init();

curl_setopt_array($curl, array(
  // para usar la api versión 2
  CURLOPT_URL => 'https://api.apis.net.pe/v2/sunat/tipo-cambio?date=' . $fecha,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 2,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Referer: https://apis.net.pe/tipo-de-cambio-sunat-api',
    'Authorization: Bearer ' . $token
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// Datos listos para usar
$tipoCambioSunat = json_decode($response);

$precioCompra = $tipoCambioSunat->precioCompra;
//echo($precioCompra);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos con Precio en Dólares</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 80%;
            max-width: 600px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background: #f2f2f2;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .actions a {
            color: #dc3545;
            text-decoration: none;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .footer {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            width: 80%;
            max-width: 600px;
        }
        .footer a {
            text-decoration: none;
            color: #007bff;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Lista de Productos con Precio en Dólares</h1>
    <form method="post" action="">
        <label for="precio_dolar">Precio del Dólar:</label>
        <input type="number" step="0.01" id="precio_dolar" name="precio_dolar" value="<?php echo $precioCompra; ?>" required>
        <input type="submit" value="Actualizar">
    </form>

    <a href="mostrar_productos.php"><input style="background-color: green" type="submit" value="Administrar Productos"></a>
    
    <br>
    <table border="1">
        <tr>
            <th>item</th>
            <th>Código del Producto</th>
            <th>Descripción del Producto</th>
            <th>Marca</th>
            <th>Costo sin IGV (S/.)</th>
            <th>valor dolar</th>
            <th>costo producto sin igb en soles</th>
            <th>costo IGV</th>
            <th>costo total inc IGV</th>
            <th>monto adicional por venta</th>
            <th>venta sin IGB</th>
            <th>IGV venta</th>
            <th>precio venta inc. IGV</th>
            <th>diferencia IGV</th>
            <th>ganancia subtotal</th>
            <th>ganancia total restando IGv</th>
            
        </tr>
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

        // Obtener el precio actual del dólar (supongamos que viene de un formulario o una API externa)
        $precio_dolar = isset($_POST['precio_dolar']) ? $_POST['precio_dolar'] : 1.00;

        // Obtener los datos de la base de datos
        $sql = "SELECT id, codigo_producto, descripcion_producto, costo_sin_igv, marca FROM productos";
        $result = $conn->query($sql);

       
        if ($result->num_rows > 0) {
            // Mostrar datos de cada fila
            while($row = $result->fetch_assoc()) {
                $costo_dolares = $row["costo_sin_igv"] * $precio_dolar;
                $monto_adicional = calcular_monto_adicional($costo_dolares);
                
                $costoIGV = ($costo_dolares*18)/100;
                $costo_Total_IGV= $costo_dolares+$costoIGV;
                $venta_sin_IGV= $costo_dolares + $monto_adicional;
                $IGV_venta = $venta_sin_IGV*0.18;
                $precio_venta_IGV=$venta_sin_IGV+$IGV_venta;
                $diferenciaIGV= $costoIGV-$IGV_venta;
                $ganancia_subtotal= $precio_venta_IGV-$costo_Total_IGV;
                $ganancia_total = $ganancia_subtotal+$diferenciaIGV;
                
                
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["codigo_producto"] . "</td>";
                echo "<td>" . $row["descripcion_producto"] . "</td>";
                echo "<td>" . $row["marca"] . "</td>";
                
                echo "<td>" . $row["costo_sin_igv"] . "</td>";
                echo "<td>" . $precio_dolar . "</td>";
                echo "<td>" . number_format($costo_dolares, 2) . "</td>";
                echo "<td>" . $costoIGV . "</td>";
                echo "<td>" . $costo_Total_IGV . "</td>";
                echo "<td>" . $monto_adicional . "</td>";
                echo "<td>" . $venta_sin_IGV . "</td>";
                echo "<td>" . $IGV_venta . "</td>";
                echo "<td>" . $precio_venta_IGV . "</td>";
                echo "<td>" . $diferenciaIGV . "</td>";
                echo "<td>" . $ganancia_subtotal . "</td>";
                echo "<td>" . $ganancia_total . "</td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No hay productos registrados</td></tr>";
        }
        $conn->close();
        ?>
    </table>
    <form action="exportar_productos.php" method="post">
        <input type="hidden" id="precio_dolar" name="precio_dolar" value="<?php echo $precioCompra; ?>">
        <input style="background-color: red; color: white; cursor: pointer;" type="submit" value="Exportar a Excel">
    </form>
</body>
</html>

