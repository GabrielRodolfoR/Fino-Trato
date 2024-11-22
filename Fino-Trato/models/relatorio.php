<?php
include('auth.php');

$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

// Consulta para calcular o lucro por mês apenas para registros com status "Aprovado"
$sql = "SELECT DATE_FORMAT(data, '%m/%Y') AS mes, SUM(precoEnd - custo) AS lucro
        FROM financeiro
        WHERE status = 'Aprovado'
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

        .rounded-image {
            border-radius: 50%;
            width: 60px;
            height: 60px;
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
                    <a href="home.php"><img src="img/brazao.png" width=75 height=75></a>
                </div>
            </div>
            <div class="middleTop"></div>
            <div class="rightTop">
                <div class="topUserImg">
                    <a href="perfil.php">
                        <img src="<?php echo isset($_SESSION['imagem']) ? $_SESSION['imagem'] : 'img/lightmdUser.png'; ?>"
                            class="rounded-image">
                    </a>
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
            <thead>
                <tr>
                    <th>Mês</th>
                    <th>Lucro Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($linha = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                        <td>{$linha['mes']}</td>
                        <td>R$ " . number_format($linha['lucro'], 2, ',', '.') . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>