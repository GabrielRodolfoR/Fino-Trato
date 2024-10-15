<?php
session_start();
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$sql = "SELECT nome, telefone, imagem, status FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($conectar, $sql);

if (mysqli_num_rows($resultado) > 0) {
    $dados = mysqli_fetch_assoc($resultado);
    $_SESSION['nome'] = $dados['nome'];
    $_SESSION['telefone'] = $dados['telefone'];
    $_SESSION['imagem'] = $dados['imagem'] ?: 'default.png';
    $_SESSION['status'] = $dados['status'];
} else {
    echo "Usuário não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>

<body>
    <div class="top">
        <div class="topUp">
            <div class="leftTop">
                <div class="logo">
                    <a href="home.php"><img src="img/logo.png" width=150 height=75></a>
                </div>
            </div>
            <div class="middleTop">
                <form action="busca.php" method="GET">
                    <div class="topSearch">
                        <input type="text" id="topSearch" name="search" placeholder="Pesquisar" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-info">Buscar</button>
                    </div>
                </form>
            </div>
            <div class="rightTop">
                <div class="topMarketCar">
                    <a><img src="img/lightmdCShop.png" width=40 height=40></a>
                </div>
                <div class="topUserImg">
                    <a href="login.php">Entrar</a>
                </div>
            </div>
        </div>
        <div class="topDown">
            <div class="navigation">
                <a href="home.php">Home</a>
                <a href="corte.php">Corte</a>
                <a href="churrasco.php">Churrasco</a>
                <a href="frios.php">Frios</a>
                <a href="pedidos.php">Personalizar</a>
                <a href="#">Ajuda e Contato</a>
            </div>
        </div>
    </div>
    <div class="container">
        <br>
        <h1 class="text-center">Bem-vindo, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</h1>
        <div class="text-center">
            <?php
            echo "<td><img src='" . $dados['imagem'] . "' width='150' height='150'></td>";
            ?>
        </div>
        <br><br>
        <p class="text-center">Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p class="text-center">Telefone: <?php echo htmlspecialchars($_SESSION['telefone']); ?></p>

        <br>
        <div class="text-center">
            <?php if ($_SESSION['status'] == 'Administrador'): ?>
                <a href="gerencia.php" class="btn btn-success">Gerenciamento</a>
            <?php endif; ?>
            <a href="pedidos.php" class="btn btn-info">Pedidos</a>
            <a href="logout.php" class="btn btn-warning">Sair</a>
        </div>
    </div>
</body>

</html>