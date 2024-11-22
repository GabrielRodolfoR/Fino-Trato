<?php
session_start();
if (isset($_SESSION['email'])) {
    header("Location: perfil.php");
    exit;
}

// Verifica se o cookie está definido e restaura a sessão
if (!isset($_SESSION['email']) && isset($_COOKIE['email']) && isset($_COOKIE['senha'])) {
    $conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

    if ($conectar) {
        $email = $_COOKIE['email'];
        $senha = $_COOKIE['senha'];

        $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
        $resultado = mysqli_query($conectar, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            $_SESSION['email'] = $email;
            header("Location: perfil.php");
            exit;
        }
    }

    mysqli_close($conectar);
}

$login_error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entrar'])) {
    $conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

    if (!$conectar) {
        die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
    }

    $email = $_POST['email'];
    $senha = md5($_POST['senha']);

    // Consultar o banco de dados
    $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
    $resultado = mysqli_query($conectar, $sql);

    if (mysqli_num_rows($resultado) == 0) {
        $login_error = true; // Credenciais inválidas
    } else {
        $_SESSION['email'] = $email;
        // Verificar se o usuário marcou a opção "Lembrar-me"
        if (isset($_POST['lembrar'])) {
            // Configurar cookies para o login persistente (1 semana)
            setcookie('email', $email, time() + (7 * 24 * 60 * 60), "/");
            setcookie('senha', $senha, time() + (7 * 24 * 60 * 60), "/");
        }

        header("Location: perfil.php");
        exit;
    }

    mysqli_close($conectar);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Entrar</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 1000px white inset;
            box-shadow: 0 0 0 1000px white inset;
            -webkit-text-fill-color: #333;
        }

        .form-group {
            position: relative;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
            background: transparent;
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            background-color: white;
            padding: 0 5px;
            color: #999;
            font-size: 16px;
            pointer-events: none;
            transition: 0.2s ease all;
        }

        .form-group input:focus+label,
        .form-group input:not(:placeholder-shown)+label {
            top: 10px;
            left: 10px;
            font-size: 12px;
            color: #333;
        }

        .form-group input:focus {
            outline: none;
            border-color: #333;
        }

        .error-box {
            color: #df4040;
            border: 1px solid #df4040;
            padding: 10px;
            margin: 10px 0;
            text-align: left;
            border-radius: 4px;
            font-size: 15;
            display: none;
        }

        .loginESignup {
            display: flex;
            justify-content: space-between;
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

    <div class="middle">
        <div class="loginESignup">
            <div class="login">
                <div class="loginTitle">
                    <h2>Já tenho uma conta</h2>
                </div>
                <div class="loginMenu">
                    <h2>Bem vindo(a)</h2>
                    <h4>Informe seus dados de login para entrar!</h4>

                    <?php
                    $login_error = false;

                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['entrar'])) {
                        $conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

                        if (!$conectar) {
                            die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
                        }

                        $email = $_POST['email'];
                        $senha = md5($_POST['senha']);

                        $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
                        $resultado = mysqli_query($conectar, $sql);

                        if (mysqli_num_rows($resultado) == 0) {
                            $login_error = true;
                        } else {
                            session_start();
                            $_SESSION['email'] = $email;
                            if (isset($_POST['lembrar'])) {
                                // Configurar cookies para o login persistente (1 semana)
                                setcookie('email', $email, time() + (7 * 24 * 60 * 60), "/");
                                setcookie('senha', $senha, time() + (7 * 24 * 60 * 60), "/");
                            }

                            header("Location: perfil.php");
                            exit;
                        }

                        mysqli_close($conectar);
                    }
                    ?>

                    <form action="login.php" method="post">
                        <div class="form-group">
                            <input type="email" id="email" name="email" placeholder=" "
                                class="<?php echo $login_error ? 'input-error' : ''; ?>" required>
                            <label for="email">E-mail</label>
                        </div>

                        <div class="form-group">
                            <input type="password" id="senha" name="senha" placeholder=" "
                                class="<?php echo $login_error ? 'input-error' : ''; ?>" required>
                            <label for="senha">Senha</label>
                        </div>

                        <div class="form-group">
                            <input type="checkbox" id="lembrar" name="lembrar">
                            <label for="lembrar">Lembrar-me</label>
                        </div>

                        <!-- Caixa de erro que aparecerá quando as credenciais forem inválidas -->
                        <div class="error-box" id="errorBox">
                            Credenciais inválidas! Tente novamente.
                        </div>

                        <input type="submit" value="Entrar" id="entrar" name="entrar">

                        <div class="php_login">
                            <?php if ($login_error): ?>
                                <script>
                                    document.getElementById('errorBox').style.display = 'block';
                                </script>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>

            <div class="signup">
                <div class="signupTitle">
                    <h2>Novo cliente</h2>
                    <h4>Se você é um cliente novo, deve se cadastrar em nossa loja. É rapidinho!</h4>
                </div>
                <div class="signupMenu">
                    <button onclick="window.location.href='cadastro.php';">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br>

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

</body>

</html>