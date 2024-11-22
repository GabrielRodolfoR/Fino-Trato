<?php
session_start();

$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!isset($_SESSION['email'])) {
    if (isset($_COOKIE['email']) && isset($_COOKIE['senha'])) {
        if ($conectar) {
            $email = $_COOKIE['email'];
            $senha = $_COOKIE['senha'];

            $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
            $resultado = mysqli_query($conectar, $sql);

            if (mysqli_num_rows($resultado) > 0) {
                $usuario = mysqli_fetch_assoc($resultado);
                $_SESSION['email'] = $email;
                $_SESSION['status'] = $usuario['status']; // Adiciona o status na sessão
            }
        }
    } else {
        header("Location: login.php");
        exit;
    }
} else {
    // Se o usuário já estiver logado, verifica o status
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM usuario WHERE email = '$email'";
    $resultado = mysqli_query($conectar, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        $_SESSION['status'] = $usuario['status']; // Atualiza o status na sessão
    }
}

mysqli_close($conectar);

// Verifica se o status é "Administrador"
if ($_SESSION['status'] !== 'Administrador') {
    header("Location: negado.php");
    exit;
}
