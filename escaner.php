<?php
echo "<h3>Archivos reales en la raíz del servidor Render:</h3>";
echo "<pre>";
$archivos = scandir(__DIR__);
foreach($archivos as $archivo) {
    if($archivo !== '.' && $archivo !== '..') {
        echo $archivo . "\n";
    }
}
echo "</pre>";
?>
