<?php
session_start(); // Inicia a sessão

// Verifica se o usuário já está logado
if (isset($_SESSION['email'])) {
    header("Location: perfil.php");
    exit; // Finaliza o script após o redirecionamento
}

// Verifica se o cookie está definido e restaura a sessão
if (!isset($_SESSION['email']) && isset($_COOKIE['email']) && isset($_COOKIE['senha'])) {
    $conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

    if ($conectar) {
        $email = $_COOKIE['email'];
        $senha = $_COOKIE['senha'];

        // Verificar as credenciais no banco de dados
        $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
        $resultado = mysqli_query($conectar, $sql);

        if (mysqli_num_rows($resultado) > 0) {
            $_SESSION['email'] = $email; // Restaurar a sessão
            header("Location: perfil.php"); // Redireciona para perfil.php
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
                                    document.getElemen tById('errorBox').style.display = 'block';
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
</body>

</html>