<?php
session_start();

// Destruir Variáveis de sessão
$_SESSION = array();

// Se os cookies de sessão estão sendo usados, remover também os cookies "lembrar-me"
if (isset($_COOKIE['email']) && isset($_COOKIE['senha'])) {
    setcookie('email', '', time() - 3600, "/"); // Expira o cookie
    setcookie('senha', '', time() - 3600, "/"); // Expira o cookie
}

// Destruir a sessão
session_destroy();
header("Location: login.php");
exit;
?>
