<?php
session_start();
session_unset();
session_destroy();

// Eliminar cookies de inicio de sesión, si existen
if (isset($_COOKIE["user_login"])) {
    setcookie("user_login", "", time() - 3600, "/");
}
if (isset($_COOKIE["userpassword"])) {
    setcookie("userpassword", "", time() - 3600, "/");
}

// Redirige al usuario a la página de inicio de sesión
header('Location: index.php');
exit();
?>
