

<?php
$inputFile = 'Archivos' . DIRECTORY_SEPARATOR . 'xac'; // Archivo con rangos
$outputPrefix = 'ips'; // Prefijo para los archivos de salida

if (!file_exists($inputFile)) {
    die("No se encontró el archivo $inputFile\n");
}

$handle = fopen($inputFile, "r");
$lineNum = 0;

while (($line = fgets($handle)) !== false) {
    $line = trim($line);
    if ($line === '') continue;

    $a = explode(',', $line);
    if (count($a) < 2) continue;

    $from = str_replace('"', '', $a[0]);
    $to   = str_replace('"', '', $a[1]);

    if (!is_numeric($from) || !is_numeric($to)) continue;

    $lineNum++;
    $outputFile = $outputPrefix . $lineNum . '.txt';
    $fp = fopen($outputFile, 'w');

    echo "Procesando línea $lineNum: $from - $to -> $outputFile\n";

    $count = 0;
    for ($i = $from; $i <= $to; $i++) {
        $ip = long2ip($i);
        fwrite($fp, $ip . PHP_EOL);
        if (++$count % 10000 == 0) echo ".";
    }

    fclose($fp);
    echo "\nArchivo $outputFile generado con $count IPs.\n";
}

fclose($handle);
echo "\nProceso completado. Total líneas procesadas: $lineNum\n";
?>
