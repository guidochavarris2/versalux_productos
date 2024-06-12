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


function accion()
{
echo("hola");

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer los encabezados de la tabla en Excel
$sheet->setCellValue('A1', 'item');
$sheet->setCellValue('B1', 'Código del Producto');
$sheet->setCellValue('C1', 'Descripción del Producto');
$sheet->setCellValue('D1', 'Marca');
$sheet->setCellValue('E1', 'Costo sin IGV dolar ($/.)');
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



$conn->close();


}


// Cerrar conexión a la base de datos

?>
