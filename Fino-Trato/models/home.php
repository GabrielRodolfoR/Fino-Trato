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
        body {
            background-color: #ececec;
            width: 100%;
            font-family: Arial, sans-serif;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: brightness(0.2);
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 60px;
            width: 60px;
        }
    </style>
</head>


<body>
    <div class="top">
        <div class="topUp">
            <div class="leftTop">
                <div class="logo">
                    <a href="home.php"><img src="img/brazao.png" width=75 height=75></a>
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
                    <a href="carrinho.php"><img src="img/lightmdCShop.png" width=40 height=40></a>
                </div>
                <div class="topUserImg">
                    <a href="perfil.php">
                        <img src="<?php echo isset($_SESSION['imagem']) ? $_SESSION['imagem'] : 'img/lightmdUser.png'; ?>" style="border-radius: 50%; width: 50px; height: 50px;">
                    </a>
                </div>
            </div>
        </div>
        <div class="topDown">
            <div class="navigation">
                <a href="home.php">Início</a>
                <a href="corte.php">Corte</a>
                <a href="churrasco.php">Churrasco</a>
                <a href="frios.php">Frios</a>
                <a href="personalizar.php">Personalizar</a>
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
        <br><br><br><br><br><br>
        <h2 class="mb-4">Catálogo de Produtos</h2>

        <?php
        if ($search) {
            $consulta = "SELECT * FROM estoque WHERE descricao LIKE '%$search%' OR madeira LIKE '%$search%' OR categoria LIKE '%$search%' AND quantidade > 0";
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
                $consulta = "SELECT * FROM estoque WHERE categoria = '$categoria' AND quantidade > 0";
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
    <br><br>
    <footer>
        <div class="footer-container">
            <!-- Coluna de navegação -->
            <div class="footer-column">
                <h3>Navegação</h3>
                <a href="home.php">Início</a>
                <a href="corte.php">Corte</a>
                <a href="churrasco.php">Churrasco</a>
                <a href="frios.php">Frios</a>
                <a href="personalizar.php">Personalizar</a>
                <a href="faq.php">FAQ</a>
            </div>

            <!-- Coluna de links de ajuda -->
            <div class="footer-column">
                <h3>Ajuda</h3>
                <a href="#">Sobre Nós</a>
                <a href="#">Política de Privacidade</a>
                <a href="#">Termos de Uso</a>
                <a href="#">Contato</a>
            </div>

            <!-- Coluna de métodos de pagamento -->
            <div class="footer-column">
                <h3>Métodos de Pagamento</h3>
                <div class="payment-icons">
                    <div class="payment-item">
                        <img src="img/pix.png" alt="Pix">
                        <span>Pix</span>
                    </div>
                    <div class="payment-item">
                        <img src="img/boleto.png" alt="Boleto">
                        <span>Boleto</span>
                    </div>
                    <div class="payment-item">
                        <img src="img/cartao.png" alt="Crédito">
                        <span>Crédito</span>
                    </div>
                    <div class="payment-item">
                        <img src="img/cartao.png" alt="Débito">
                        <span>Débito</span>
                    </div>
                </div>
            </div>

            <!-- Coluna de contato e redes sociais -->
            <div class="footer-column">
                <h3>Contato</h3>
                <p>Email: giovanerabello531@gmail.com</p>
                <p>Telefone: (48) 99956-9805</p>
                <div class="social-icons">
                    <a href="https://www.facebook.com/giovane.rabello.77?_rdr"><img src="img/facebook_icon.png" alt="Facebook"></a>
                    <a href="#"><img src="img/whatsapp_icon.png" alt="Whatsapp"></a>
                    <a href="#"><img src="img/instagram_icon.png" alt="Instagram"></a>
                </div>
            </div>
        </div>

        <div class="copyright">
            &copy; 2024 Finotrato. Todos os direitos reservados.
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>