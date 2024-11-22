<?php
session_start();
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];
$mensagem = '';

// Recupera os dados do usuário do banco de dados
$sql = "SELECT telefone, status, imagem FROM usuario WHERE email = '$email'";
$result = mysqli_query($conectar, $sql);
if (mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
    $_SESSION['telefone'] = $usuario['telefone'];
    $_SESSION['status'] = $usuario['status'];
    $_SESSION['imagem'] = $usuario['imagem']; // Adicionando a imagem na sessão
}

// Lógica para atualizar a imagem de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
    $nomeArquivo = basename($_FILES['imagem']['name']);
    $diretorioDestino = 'ImageUser/' . $nomeArquivo;

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorioDestino)) {
        $sql = "UPDATE usuario SET imagem = '$diretorioDestino' WHERE email = '$email'";
        if (mysqli_query($conectar, $sql)) {
            $_SESSION['imagem'] = $diretorioDestino;

            if (isset($_COOKIE['imagem'])) {
                setcookie('imagem', $diretorioDestino, time() + (86400 * 30), "/");
            }

            $mensagem = "Imagem de perfil atualizada com sucesso!";
        } else {
            $mensagem = "Erro ao atualizar a imagem no banco de dados.";
        }
    } else {
        $mensagem = "Erro ao mover o arquivo para o diretório de destino.";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = "Erro ao enviar o arquivo.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <style>
        body {
            background-color: #ececec;
            width: 100%;
            font-family: Arial, sans-serif;
        }

        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .profile-image {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
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

    <!-- Conteúdo do perfil -->
    <div class="profile-container mt-5">
        <?php if ($mensagem): ?>
            <div class="alert alert-info"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <img src="<?php echo isset($_SESSION['imagem']) ? $_SESSION['imagem'] : 'img/lightmdUser.png'; ?>"
            alt="Foto do Perfil" class="profile-image">
        <button class="btn-edit-photo" data-toggle="modal" data-target="#editPhotoModal">Alterar foto</button>

        <div class="profile-info">
            <p><strong>E-mail:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
            <p><strong>Telefone:</strong>
                <?php echo isset($_SESSION['telefone']) ? htmlspecialchars($_SESSION['telefone']) : 'Telefone não disponível'; ?>
            </p>
        </div>

        <div class="mt-3">
            <?php if ($_SESSION['status'] == 'Administrador'): ?>
                <a href="gerencia.php" class="btn btn-success">Gerenciamento</a>
            <?php endif; ?>
            <a href="pedidos.php" class="btn btn-info">Pedidos</a>
            <a href="logout.php" class="btn btn-warning">Sair</a>
        </div>
    </div>

    <!-- Modal de edição de foto -->
    <div class="modal fade" id="editPhotoModal" tabindex="-1" role="dialog" aria-labelledby="editPhotoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel">Alterar Foto de Perfil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <label for="imagem">Escolha uma nova foto de perfil:</label>
                        <input type="file" name="imagem" id="imagem" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Atualizar Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>