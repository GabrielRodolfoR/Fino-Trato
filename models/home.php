<?php
session_start();
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($conectar, $_GET['search']) : null;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Início</title>
    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: black;
        }

        .carousel-control-prev,
        .carousel-control-next {
            filter: invert(1);
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 5%;
        }

        .carousel-control-prev {
            left: 0;
        }

        .carousel-control-next {
            right: 0;
        }
    </style>
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
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="perfil.php">Perfil</a>
                    <?php else: ?>
                        <a href="login.php">Entrar</a>
                    <?php endif; ?>
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
        <div class="carousel slide" id="carouselExampleIndicators" data-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/homeBanner1.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <a href="pedidos.php"><img src="img/homeBanner2.png" class="d-block w-100" alt="..."></a>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Próximo</span>
            </a>
        </div>

        <h2 class="mb-4">Catálogo de Produtos</h2>

        <?php
        if ($search) {
            $consulta = "SELECT * FROM estoque WHERE descricao LIKE '%$search%' OR madeira LIKE '%$search%' OR categoria LIKE '%$search%'";
            $resultado = mysqli_query($conectar, $consulta);
            $totalProdutos = mysqli_num_rows($resultado);

            if ($totalProdutos > 0) {
                echo '<div class="row">';
                while ($produto = mysqli_fetch_assoc($resultado)) {
                    echo '<div class="col-md-3 mb-3">';
                    echo '<div class="card" style="width: 280px;">';
                    echo '<img class="card-img-top" style="width: 278px; height: 200px;" src="' . $produto['imagem'] . '" alt="Imagem do Produto">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title"> Tábua de ' . $produto['categoria'] . '</h5>';
                    echo '<h6 class="card-subtitle mb-2 text-body-secondary">' . $produto['madeira'] . '</h6>';
                    echo '<p class="card-text">' . $produto['descricao'] . '</p>';
                    echo '<p class="card-text">Preço: R$ ' . $produto['preco'] . '</p>';
                    echo '<a href="detalhes.php?codigo=' . $produto['codigo'] . '" class="btn btn-primary">Ver detalhes</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<p>Nenhum produto encontrado para a pesquisa: ' . htmlspecialchars($search) . '.</p>';
            }
        } else {
            $categorias = array('Frios', 'Corte', 'Churrasco');
            foreach ($categorias as $categoria) {
                $consulta = "SELECT * FROM estoque WHERE categoria = '$categoria'";
                $resultado = mysqli_query($conectar, $consulta);
                $totalProdutos = mysqli_num_rows($resultado);

                echo '<h3>' . $categoria . '</h3>';
                if ($totalProdutos > 4) {
                    echo '<div id="carousel-' . $categoria . '" class="carousel slide" data-ride="carousel" data-interval="false">';
                    echo '<div class="carousel-inner">';
                    echo '<div class="carousel-item active"><div class="row">';

                    $contador = 0;
                    while ($produto = mysqli_fetch_assoc($resultado)) {
                        if ($contador > 0 && $contador % 4 == 0) {
                            echo '</div></div><div class="carousel-item"><div class="row">';
                        }
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
                        $contador++;
                    }
                    echo '</div></div>';
                    echo '</div>';
                    echo '<a class="carousel-control-prev" href="#carousel-' . $categoria . '" role="button" data-slide="prev">';
                    echo '<span class="carousel-control-prev-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Anterior</span>';
                    echo '</a>';
                    echo '<a class="carousel-control-next" href="#carousel-' . $categoria . '" role="button" data-slide="next">';
                    echo '<span class="carousel-control-next-icon" aria-hidden="true"></span>';
                    echo '<span class="sr-only">Próximo</span>';
                    echo '</a>';
                    echo '</div>';
                } elseif ($totalProdutos >= 1) {
                    echo '<div class="row">';
                    while ($produto = mysqli_fetch_assoc($resultado)) {
                        echo '<div class="col-md-3 mb-3">';
                        echo '<div class="card" style="width: 280px;">';
                        echo '<img class="card-img-top" style="width: 278px; height: 200px;" src="' . $produto['imagem'] . '" alt="Imagem do Produto">';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title"> Tábua de ' . $produto['categoria'] . '</h5>';
                        echo '<h6 class="card-subtitle mb-2 text-body-secondary">' . $produto['madeira'] . '</h6>';
                        echo '<p class="card-text">' . $produto['descricao'] . '</p>';
                        echo '<p class="card-text">Preço: R$ ' . $produto['preco'] . '</p>';
                        echo '<a href="detalhes.php?codigo=' . $produto['codigo'] . '" class="btn btn-primary">Ver detalhes</a>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>Nenhum produto disponível na categoria ' . $categoria . ' no momento.</p>';
                }
                echo '<br>';
            }
        }
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>