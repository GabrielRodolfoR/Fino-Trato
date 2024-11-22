<?php
session_start(); // Certifique-se de iniciar a sessão

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
        exit;
    }
} else {
    echo '<p>Código do produto não especificado.</p>';
    exit;
}

// Função para adicionar produtos ao carrinho
function adicionarAoCarrinho($codigo, $nomeProduto, $preco, $quantidade, $madeira, $descricao)
{
    // Carrinho existe
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = array();
    }

    // Verifica se já está no carrinho
    $produtoExiste = false;
    foreach ($_SESSION['carrinho'] as &$produto) {
        if ($produto['codigo'] == $codigo) {
            // Se o produto já existe, incrementa a quantidade
            $produto['quantidade'] += $quantidade;
            $produtoExiste = true;
            break;
        }
    }

    if (!$produtoExiste) {
        $_SESSION['carrinho'][] = array(
            'codigo' => $codigo,
            'nome' => $nomeProduto,
            'preco' => $preco,
            'quantidade' => $quantidade,
            'madeira' => $madeira,
            'descricao' => $descricao
        );
    }
}

// Verifica se um produto deve ser adicionado ao carrinho
if (isset($_POST['adicionar'])) {
    $codigo = $_POST['codigo'];
    $nomeProduto = $_POST['nomeProduto'];
    $preco = $_POST['preco'];
    $quantidade = isset($_POST['quantidade']) ? intval($_POST['quantidade']) : 1;
    $madeira = $_POST['madeira'];
    $descricao = $_POST['descricao'];

    adicionarAoCarrinho($codigo, $nomeProduto, $preco, $quantidade, $madeira, $descricao);
    // Redirecionar para evitar reenvio do formulário
    header("Location: carrinho.php");
    exit();
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
    <style>
        body {
            background-color: #ececec;
            width: 100%;
            font-family: Arial, sans-serif;
        }

        img.img-fluid {
            height: 250px;
            max-width: 350px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            margin-left: 50px;
        }

        .col-md-6 h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        .container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
            max-width: 900px;
        }

        .col-md-6 p {
            font-size: 16px;
            margin: 5px 0;
            color: #555;
        }

        .col-md-6 strong {
            color: #000;
        }

        .btn-info {
            background-color: #007bff;
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-info:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            border: none;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-warning:hover {
            background-color: #cc5200;
        }

        .input-group {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 200px;
            margin: 10px 0;
        }

        .input-group button {
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            font-size: 20px;
            padding: 5px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .input-group button:hover {
            background-color: #e0e0e0;
        }

        .input-group input {
            width: 60px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 16px;
            margin: 0 5px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .row {
                flex-direction: column;
                align-items: center;
            }

            .col-md-6 {
                text-align: center;
            }

            img.img-fluid {
                max-width: 80%;
                height: auto;
            }

            .navigation {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .navigation a {
                margin: 5px 10px;
            }
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
        <h2 class="mt-4" style="margin-left: 60px;">Detalhes do Produto</h2>
        <div class="row mt-4">
            <div class="col-md-6">
                <img src="<?php echo $produto['imagem']; ?>" class="img-fluid" alt="Imagem do Produto">
            </div>
            <div class="col-md-6">
                <h3 class="mb-3">Tábua de <?php echo $produto['categoria']; ?></h3>
                <h5 class="mb-3"><strong>Madeira(s) utilizadas: </strong><?php echo $produto['madeira']; ?></h5>
                <p><strong>Descrição: </strong><?php echo $produto['descricao']; ?></p>
                <p><strong>Quantidade Disponível: </strong><?php echo $produto['quantidade']; ?></p>
                <p><strong>Preço:</strong> R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>

                <!-- Formulário para adicionar ao carrinho com seleção de quantidade -->
                <form action="" method="POST">
                    <input type="hidden" name="codigo" value="<?php echo $produto['codigo']; ?>">
                    <input type="hidden" name="nomeProduto" value="<?php echo $produto['categoria']; ?>">
                    <input type="hidden" name="preco" value="<?php echo $produto['preco']; ?>">
                    <input type="hidden" name="madeira" value="<?php echo $produto['madeira']; ?>">
                    <input type="hidden" name="descricao" value="<?php echo $produto['descricao']; ?>">

                    <label for="quantidade">Quantidade:</label>
                    <div class="input-group mb-4">

                        <button class="btn btn-outline-secondary" type="button" id="decrease">-</button>
                        <input type="number" name="quantidade" id="quantidade" value="1" min="1"
                            max="<?php echo $produto['quantidade']; ?>" class="form-control text-center" required>
                        <button class="btn btn-outline-secondary" type="button" id="increase">+</button>
                    </div>
                    <button type="submit" name="adicionar" class="btn btn-info mb-4">Adicionar ao Carrinho</button>
                    <a href="home.php" class="btn btn-warning mb-4">Voltar ao Catálogo</a>
                </form>


            </div>
        </div>

        <!-- Modal Pagamentos -->
        <div class="modal fade" id="myModalPay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2>Método de pagamento:</h2>
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
        </div>
        <br><br><br><br>
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
        <script>
            document.getElementById('increase').addEventListener('click', function() {
                var quantidadeInput = document.getElementById('quantidade');
                var max = parseInt(quantidadeInput.max);
                var current = parseInt(quantidadeInput.value);
                if (current < max) {
                    quantidadeInput.value = current + 1;
                }
            });

            document.getElementById('decrease').addEventListener('click', function() {
                var quantidadeInput = document.getElementById('quantidade');
                var current = parseInt(quantidadeInput.value);
                if (current > 1) {
                    quantidadeInput.value = current - 1;
                }
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>