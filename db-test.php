<?php
$link = mysqli_connect('localhost', 'root', 'cesar1911', 'geekcollector');

if (!$link) {
    die('Error de conexión: ' . mysqli_connect_error());
}
echo 'Conexión exitosa a la base de datos';
mysqli_close($link);
?>
