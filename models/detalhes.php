<?php
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    $consulta = "SELECT * FROM estoque WHERE codigo = '$codigo'";
    $resultado = mysqli_query($conectar, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $produto = mysqli_fetch_assoc($resultado);
    } else {
        echo '<p>Produto não encontrado.</p>';
        exit; // Encerra a execução se o produto não for encontrado
    }
} else {
    echo '<p>Código do produto não especificado.</p>';
    exit; // Encerra a execução se o código não estiver presente
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Detalhes do Produto</title>
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
        <h2 class="mt-4">Detalhes do Produto</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="<?php echo $produto['imagem']; ?>" class="img-fluid" alt="Imagem do Produto">
            </div>
            <div class="col-md-6">
                <h3 class="mb-3">Tábua de <?php echo $produto['categoria']; ?></h3>
                <h5 class="mb-3"><strong>Madeira(s) utilizadas: </strong><?php echo $produto['madeira']; ?></h5>
                <p><strong>Descição: </strong><?php echo $produto['descricao']; ?></p>
                <p><strong>Quantidade Disponível: </strong><?php echo $produto['quantidade']; ?></p>
                <p><strong>Preço:</strong> R$ <?php echo $produto['preco']; ?></p>
                <a href="#" class="btn btn-success mb-4" data-toggle="modal" data-target="#myModalPay">Comprar</a>
                <a href="#" class="btn btn-info mb-4">Adicionar ao Carrinho</a>
                <a href="home.php" class="btn btn-warning mb-4">Voltar ao Catálogo</a>
            </div>
        </div>

        <!--Modal Pagamentos-->
        <div class="modal fade" id="myModalPay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Metodo de pagamento: </h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body md-3">
                        <button class="btn btn-info" data-bs-toggle="popover" title="Popover title">Cartão</button>
                        <hr>
                        <button class="btn btn-info" data-bs-toggle="popover" title="Popover title">Pix</button>
                        <hr>
                        <button class="btn btn-info" data-bs-toggle="popover" title="Popover title">Boleto</button>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>