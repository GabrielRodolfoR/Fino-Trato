<?php
session_start();
if (isset($_SESSION['compra_erro'])) {
    echo "<h1>Erro na Compra</h1>";
    echo "<p>" . $_SESSION['compra_erro'] . "</p>";
    unset($_SESSION['compra_erro']);
} else {
    echo "<h1>Erro desconhecido.</h1>";
}
?>
