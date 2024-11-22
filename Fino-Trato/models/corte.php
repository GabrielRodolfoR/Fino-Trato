<?php
session_start();
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
    <style>
        body {
            background-color: #ececec !important;
            width: 100%;
            font-family: Arial, sans-serif;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Início</title>
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
                        <input type="text" id="topSearch" name="search" placeholder="Pesquisar"
                            value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
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
                        <img src="<?php echo isset($_SESSION['imagem']) ? $_SESSION['imagem'] : 'img/lightmdUser.png'; ?>"
                            style="border-radius: 50%; width: 50px; height: 50px;">
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
        <h2 class="mb-4">Tábuas de Corte</h2>
        <?php
        $consulta = "SELECT * FROM estoque WHERE categoria = 'Corte'";
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
                echo '<p>Nenhum produto disponívem em Corte.</p>';
            }
            ?>
        </div>

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
                    <a href="https://www.facebook.com/giovane.rabello.77?_rdr"><img src="img/facebook_icon.png"
                            alt="Facebook"></a>
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