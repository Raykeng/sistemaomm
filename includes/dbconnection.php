<?php 
// DB credentials.
define('DB_HOST','sql104.infinityfree.com'); // Cambiado el host
define('DB_USER','if0_37685175'); // Cambiado el usuario
define('DB_PASS','v1kbxgLntPMFAE'); // Cambiada la contraseña (asegúrate de reemplazarla con la correcta)
define('DB_NAME','if0_37685175_oficinamujer'); // Cambiado el nombre de la base de datos
define('DB_PORT', '3306'); // Puerto especificado

// Establish database connection.
try
{
    $dbh = new PDO("mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
    exit("Error: " . $e->getMessage());
}
?>
