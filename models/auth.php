<?php
session_start();

if (!isset($_SESSION['email'])) {
    if (isset($_COOKIE['email']) && isset($_COOKIE['senha'])) {
        $conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

        if ($conectar) {
            $email = $_COOKIE['email'];
            $senha = $_COOKIE['senha'];

            $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
            $resultado = mysqli_query($conectar, $sql);

            if (mysqli_num_rows($resultado) > 0) {
                $_SESSION['email'] = $email;
            }
        }

        mysqli_close($conectar);
    } else {
        header("Location: login.php");
        exit;
    }
}