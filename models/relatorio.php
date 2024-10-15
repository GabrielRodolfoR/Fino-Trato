<?php
include('auth.php');
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Consulta para calcular o lucro por mês
$sql = "SELECT DATE_FORMAT(data, '%m/%Y') AS mes, SUM(precoEnd - custo) AS lucro
        FROM financeiro
        GROUP BY mes
        ORDER BY mes DESC";

$resultado = mysqli_query($conectar, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <style>
        .middleTop {
            width: 500px;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Relatório de Lucro por Mês</title>
</head>

<body>
    <div class="top">
        <div class="topUp">
            <div class="leftTop">
                <div class="logo">
                    <a href="home.php"><img src="img/adm_logo.png" width=150 height=75></a>
                </div>
            </div>
            <div class="middleTop"></div>
            <div class="rightTop">
                <div class="topUserImg">
                    <a href="login.php"><img src="img/lightmdUser.png" width=40 height=40></a>
                </div>
            </div>
        </div>
        <div class="topDown">
            <div class="navigation">
                <a href="usuarios.php">Usuários</a>
                <a href="estoque.php">Estoque</a>
                <a href="pedidos.php">Pedidos</a>
                <a href="financeiro.php">Financeiro</a>
                <a href="producao.php">Produção</a>
                <a href="entrega.php">Entrega</a>
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="mt-4">Relatório de Lucro por Mês
            <a href="financeiro.php" class="btn btn-primary">Voltar para o Financeiro</a>
        </h2>
        <table class="table table-hover table-bordered table-striped">
                <th>Mês</th>
                <th>Lucro Total</th>
            <?php
            while ($linha = mysqli_fetch_assoc($resultado)) {
                echo "<tr>
                    <td>{$linha['mes']}</td>
                    <td>R$ " . number_format($linha['lucro'], 2, ',', '.') . "</td>
                </tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>