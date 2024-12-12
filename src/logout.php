<?php
/** 
 * Fuente:
 * "El gran libro de PHP", Editorial Marcombo"
 * */

session_start(); // Retomamos la sesión existente

// Destruir todas las variables de sesión y sus valores
$_SESSION = array();

// borrar la cookie de sesión si existía.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// destruir la sesión.
session_destroy();

// Redirigir al usuario a la página de inicio de sesión
header("Location: login.php");
exit;
?>