<?php
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$categorias = array('Frios', 'Corte', 'Churrasco');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Início</title>
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
                    <a href="login.php"><img src="img/lightmdUser.png" width=40 height=40></a>
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
        <h2 class="mb-4">Tábuas de Churrasco</h2>

        <?php
        $consulta = "SELECT * FROM estoque WHERE categoria = 'Churrasco'";
        $resultado = mysqli_query($conectar, $consulta);
        ?>
        <div class="row">
            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($produto = mysqli_fetch_assoc($resultado)) {
                    echo '<div class="col-md-3 mb-3">';
                    echo '<div class="card" style="width: 280px;">';
                    echo '<img class="card-img-top" style="width: 278px; height: 200px;" src="' . $produto['imagem'] . '" alt="Imagem do Produto">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title"> Tábua de ' . $produto['categoria'] . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-body-secondary">' . $produto['madeira'] . '</h6>';
                    echo '<p class="card-text">' . $produto['descricao'] . '</p>';
                    echo '<p class="card-text">Preço: R$ ' . $produto['preco'] . '</p>';
                    // Detalhes do produto
                    echo '<a href="detalhes.php?codigo=' . $produto['codigo'] . '" class="btn btn-primary">Ver detalhes</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Nenhum produto disponívem em Churrasco.</p>';
            }
            ?>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>