<?php
session_start();

session_destroy();

echo 'Su sesión ha sido cerrada';
session_start();
$_SESSION['errores'] = 0;

?>