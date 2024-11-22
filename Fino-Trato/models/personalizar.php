<?php
session_start();
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$nomeUsuario = isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário'; // Assumindo que 'nome' vem da sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $tipoMadeira = $_POST['tipoMadeira'];
    $comprimento = $_POST['comprimento'];
    $largura = $_POST['largura'];
    $espessura = $_POST['espessura'];
    $descricao = $_POST['descricao'];
    
    // Processa o upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $pastaDestino = 'imageOrder/';
        $nomeImagem = basename($_FILES['imagem']['name']);
        $caminhoImagem = $pastaDestino . uniqid() . '_' . $nomeImagem;

        // Move a imagem para a pasta destino
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoImagem)) {
            // Insere os dados no banco de dados
            $sql = "INSERT INTO pedido (nomeUsuario, imagem, madeira, comprimento, largura, espessura, descricao) 
                    VALUES ('$nomeUsuario', '$caminhoImagem', '$tipoMadeira', '$comprimento', '$largura', '$espessura', '$descricao')";

            if (mysqli_query($conectar, $sql)) {
                echo "Pedido finalizado com sucesso!";
                header("Location: home.php");  // Redireciona após sucesso
                exit();
            } else {
                echo "Erro ao finalizar o pedido: " . mysqli_error($conectar);
            }
        } else {
            echo "Erro ao mover a imagem para a pasta destino.";
        }
    } else {
        echo "Erro no upload da imagem.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Personalizar</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        background-color: #f2f2f2;
    }

    .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 800px;
            text-align: center;
        }
        h2 {
            font-size: 24px;
            color: #666;
            margin-bottom: 20px;
            margin-top: -5px;
        }
        .content {
            display: flex;
            gap: 20px;
            justify-content: center;
            width: 100%;
        }
        .image-upload {
            border: 2px dashed #ccc;
            width: 400px;
            height: 400px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #999;
            text-align: center;
            padding: 20px;
            box-sizing: border-box;
        }
        .image-upload input[type="file"] {
            margin-top: 10px;
            padding: 10px 20px;
            border: 1px solid #999;
            background: #fff;
            cursor: pointer;
        }
        .form-section {
            width: 300px;
            text-align: left;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            box-sizing: border-box;
            outline: none;
        }

        .form-group input:focus, textarea:focus {
            border: 1px solid rgb(107, 107, 107);
        }

        .form-group textarea {
            resize: none;
            height: 80px;
        }
        .submit-button {
            background-color: #e47e40;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            box-sizing: border-box;
        }

        .image-upload {
            border: 2px dashed #ccc;
            width: 400px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        .image-upload img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #changeImageButton {
            margin-top: 10px;
            padding: 8px 12px;
            background-color: #e47e40;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
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

    <div class="middle">
        <div class="container">
            <h2>Tábua personalizada</h2>
            <form id="formPersonalizar" action="personalizar.php" method="POST" enctype="multipart/form-data">
                <div class="content">
                    <div class="image-upload" id="imageUploadContainer">
                        <div id="uploadMessage">
                            <p><strong>Imagem prototipada</strong></p>
                            <p>Insira aqui a imagem de um modelo parecido com o que você deseja.</p>
                            <input type="file" name="imagem" id="imagem" accept="imageOrder/*" required>
                        </div>
                        <img id="previewImage" style="display: none;" alt="Pré-visualização da imagem">
                        <button id="changeImageButton" style="display: none;">Trocar Imagem</button>
                    </div>
                    <div class="form-section">
                        <div class="form-group">
                            <label for="tipoMadeira">Tipo de madeira:</label>
                            <select id="tipoMadeira" name="tipoMadeira" required>
                                <option disabled>Selecione...</option>
                                <option>Madeira 1</option>
                                <option>Madeira 2</option>
                                <option>Madeira 3</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comprimento">Comprimento:</label>
                            <input type="number" id="comprimento" name="comprimento" placeholder="mm" required>
                        </div>
                        <div class="form-group">
                            <label for="largura">Largura:</label>
                            <input type="number" id="largura" name="largura" placeholder="mm" required>
                        </div>
                        <div class="form-group">
                            <label for="espessura">Espessura:</label>
                            <input type="number" id="espessura" name="espessura" placeholder="mm" required>
                        </div>
                        <div class="form-group">
                            <label for="descricao">Dê uma descrição detalhada do seu pedido:</label>
                            <textarea id="descricao" name="descricao" required></textarea>
                        </div>
                        <button type="submit" id="finalizar" class="submit-button">Finalizar pedido</button>
                    </div>
                </div>
            </form>
        </div>
    </div>      
    
    </div>
    <br><br><br><br>

    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>Navegação</h3>
                <a href="home.php">Início</a>
                <a href="corte.php">Corte</a>
                <a href="churrasco.php">Churrasco</a>
                <a href="frios.php">Frios</a>
                <a href="personalizar.php">Personalizar</a>
                <a href="faq.php">FAQ</a>
            </div>

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
        // Função para visualizar a imagem selecionada
        function previewImagem(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.getElementById('imagem').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImage = document.getElementById('previewImage');
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
                document.getElementById('uploadMessage').style.display = 'none'; // Oculta a mensagem e o input
            };
            reader.readAsDataURL(file);
        }
    });

    </script>
</body>
</html>