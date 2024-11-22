<?php
session_start();
session_regenerate_id(true);
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

if (isset($_COOKIE['email'], $_COOKIE['nome'], $_COOKIE['telefone'], $_COOKIE['imagem'])) {
    $_SESSION['email'] = $_COOKIE['email'];
    $_SESSION['nome'] = $_COOKIE['nome'];
    $_SESSION['telefone'] = $_COOKIE['telefone'];
    $_SESSION['imagem'] = $_COOKIE['imagem'];
}

if (!isset($_SESSION['email'])) {
    echo "<script>alert('Você precisa estar logado para fazer uma compra.');</script>";
    exit;
}

$email = $_SESSION['email'];
$sql = "SELECT nome, telefone, imagem, status, codigo, cpf, endereco FROM usuario WHERE email = '$email'";
$resultado = mysqli_query($conectar, $sql);

if (mysqli_num_rows($resultado) > 0) {
    $dados = mysqli_fetch_assoc($resultado);
    $_SESSION['nome'] = $dados['nome'];
    $_SESSION['telefone'] = $dados['telefone'];
    $_SESSION['imagem'] = $dados['imagem'] ? $dados['imagem'] : 'default.png';
    $_SESSION['status'] = $dados['status'];
    $_SESSION['codigo'] = $dados['codigo'];
    $_SESSION['cpf'] = $dados['cpf'];
    $_SESSION['endereco'] = $dados['endereco'];
} else {
    echo "<script>alert('Usuário não encontrado.');</script>";
    exit;
}

// Função para finalizar a compra
function finalizarCompra($conectar, $codigoUsuario, $cpf, $endereco)
{
    if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
        return "Carrinho vazio.";
    }

    $status = "Aprovado";
    $data = date("Y-m-d H:i:s");

    foreach ($_SESSION['carrinho'] as $produto) {
        $codigoProduto = $produto['codigo'];
        $quantidadeCompra = $produto['quantidade'];
        $precoEnd = number_format($produto['preco'] * $quantidadeCompra, 2, '.', '');

        // Cria a descrição do pedido
        $categoria = $produto['nome'];
        $descricaoProduto = "Tabua de $categoria (" . $produto['descricao'] . ") - Quantidade: $quantidadeCompra";

        // Verificar estoque
        $sqlCheckEstoque = sprintf(
            "SELECT quantidade FROM estoque WHERE codigo = '%s'",
            mysqli_real_escape_string($conectar, $codigoProduto)
        );
        $resultadoEstoque = mysqli_query($conectar, $sqlCheckEstoque);
        if (!$resultadoEstoque) {
            return "Erro ao executar consulta de estoque: " . mysqli_error($conectar);
        }
        $estoqueAtual = mysqli_fetch_assoc($resultadoEstoque);
        if ($estoqueAtual['quantidade'] < $quantidadeCompra) {
            return "Estoque insuficiente para o produto $codigoProduto.";
        }

        // Inserir na tabela entrega
        $sqlEntrega = sprintf(
            "INSERT INTO entrega (codUsuario, cpf, endereco, produto, status) VALUES (%d, '%s', '%s', '%s', '%s')",
            $codigoUsuario,
            mysqli_real_escape_string($conectar, $cpf),
            mysqli_real_escape_string($conectar, $endereco),
            mysqli_real_escape_string($conectar, $descricaoProduto),
            $status
        );
        if (!mysqli_query($conectar, $sqlEntrega)) {
            return "Erro ao inserir na tabela entrega: " . mysqli_error($conectar);
        }

        // Inserir na tabela financeiro com descrição no lugar de codPedido
        $sqlFinanceiro = sprintf(
            "INSERT INTO financeiro (codPedido, codUsuario, custo, precoEnd, lucro, data, status) 
             VALUES ('%s', %d, %.2f, %.2f, %.2f, '%s', '%s')",
            mysqli_real_escape_string($conectar, $descricaoProduto),
            $codigoUsuario,
            $precoEnd,
            $precoEnd,
            0,
            $data,
            $status
        );
        if (!mysqli_query($conectar, $sqlFinanceiro)) {
            return "Erro ao inserir na tabela financeiro: " . mysqli_error($conectar);
        }

        // Atualizar estoque
        $sqlEstoque = sprintf(
            "UPDATE estoque SET quantidade = quantidade - %d WHERE codigo = '%s'",
            $quantidadeCompra,
            mysqli_real_escape_string($conectar, $codigoProduto)
        );
        if (!mysqli_query($conectar, $sqlEstoque)) {
            return "Erro ao atualizar estoque para o produto $codigoProduto: " . mysqli_error($conectar);
        }
    }

    return true;
}

// Lógica para confirmar a compra
if (isset($_POST['confirmarCompra'])) {
    $cpf = mysqli_real_escape_string($conectar, $_POST['cpf']);
    $endereco = mysqli_real_escape_string($conectar, $_POST['endereco']);
    $codigoUsuario = $_SESSION['codigo'];

    if (empty($cpf) || empty($endereco)) {
        $_SESSION['compra_erro'] = 'CPF ou endereço não fornecidos.';
        header('Location: erro.php');
        exit;
    } else {
        $resultado = finalizarCompra($conectar, $codigoUsuario, $cpf, $endereco);
        if ($resultado === true) {
            $_SESSION['compra_sucesso'] = true;
            unset($_SESSION['carrinho']); // Limpa o carrinho
            header('Location: perfil.php'); // Página de sucesso
            exit;
        } else {
            $_SESSION['compra_erro'] = $resultado;
            header('Location: erro.php');
            exit;
        }
    }
}

// Lógica para remover um produto do carrinho
if (isset($_GET['remover'])) {
    $codigoProduto = $_GET['remover'];
    if (isset($_SESSION['carrinho']) && !empty($_SESSION['carrinho'])) {
        foreach ($_SESSION['carrinho'] as $key => $produto) {
            if ($produto['codigo'] == $codigoProduto) {
                unset($_SESSION['carrinho'][$key]);
                break;
            }
        }
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    }

    echo "<script>alert('Produto removido do carrinho.');</script>";
}

$valorTotal = 0;
if (!empty($_SESSION['carrinho'])) {
    foreach ($_SESSION['carrinho'] as $produto) {
        $valorTotal += $produto['preco'] * $produto['quantidade'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>Carrinho - Fino Trato</title>
    <style>
        .produto-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .produto-card h4 {
            font-size: 18px;
            font-weight: bold;
        }

        .produto-card p {
            margin: 0;
            font-size: 14px;
        }

        .total {
            text-align: right;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .comprar-btn {
            background-color: #ff7f0e;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        .comprar-btn:hover {
            background-color: #e66805;
        }

        .modal-content {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal-header {
            background-color: #ff7f0e;
            color: white;
        }

        .modal-header .close {
            color: white;
        }

        .modal-body {
            padding: 20px;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
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

    <br><br>
    <div class="container">
        <div class="card shadow-sm p-4" style="background-color: #fff; border-radius: 10px;">
            <h2>Seu Carrinho</h2>
            <div class="row">

                <div class="col-md-8">
                    <?php if (!empty($_SESSION['carrinho'])): ?>
                        <?php foreach ($_SESSION['carrinho'] as $produto): ?>
                            <div class="produto-card">
                                <h4>Tábua de <?php echo $produto['nome']; ?></h4>
                                <p>Madeira: <?php echo isset($produto['madeira']) ? $produto['madeira'] : 'Não especificado'; ?>
                                </p>
                                <p>Descrição:
                                    <?php echo isset($produto['descricao']) ? $produto['descricao'] : 'Não especificada'; ?>
                                </p>
                                <p>Quantidade: <?php echo $produto['quantidade']; ?></p>
                                <p>Subtotal:
                                    R$<?php echo number_format($produto['preco'] * $produto['quantidade'], 2, ',', '.'); ?>
                                </p>
                                <a href="carrinho.php?remover=<?php echo $produto['codigo']; ?>"
                                    class="btn btn-danger">Excluir</a>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>O carrinho está vazio.</p>
                    <?php endif; ?>
                </div>

                <div class="col-md-4">
                    <div class="produto-card">
                        <h4>Valor Total</h4>
                        <p class="total">R$<?php echo number_format($valorTotal, 2, ',', '.'); ?></p>
                        <button type="button" class="comprar-btn" data-toggle="modal" data-target="#confirmModal">
                            Comprar
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmar Compra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="confirmForm" action="" method="POST">
                            <div class="form-group">
                                <label for="cpf">CPF:</label>
                                <input type="text" id="cpf" name="cpf" class="form-control"
                                    value="<?php echo $_SESSION['cpf']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="endereco">Endereço:</label>
                                <input type="text" id="endereco" name="endereco" class="form-control"
                                    value="<?php echo $_SESSION['endereco']; ?>" required>
                            </div>
                            <h4>Valor Total</h4>
                            <p>R$<?php echo number_format($valorTotal, 2, ',', '.'); ?></p>

                            <h5>Selecione o método de pagamento:</h5>
                            <div class="form-check">
                                <input class="form-check-input metodo-pagamento" type="radio" name="metodoPagamento"
                                    id="cartaoCredito" value="Cartão de Crédito" required>
                                <label class="form-check-label" for="cartaoCredito">
                                    <i class="fas fa-credit-card"></i> Cartão de Crédito
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input metodo-pagamento" type="radio" name="metodoPagamento"
                                    id="boleto" value="Boleto">
                                <label class="form-check-label" for="boleto">
                                    <i class="fas fa-file-invoice"></i> Boleto Bancário
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input metodo-pagamento" type="radio" name="metodoPagamento"
                                    id="pix" value="Pix">
                                <label class="form-check-label" for="pix">
                                    <i class="fas fa-qrcode"></i> Pix
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="proximo" class="btn btn-primary">Próximo</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Cartão de Crédito -->
        <div class="modal fade" id="cartaoCreditoModal" tabindex="-1" aria-labelledby="cartaoCreditoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cartaoModalLabel">Pagamento com Cartão de Crédito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    </div>
                    <div class="modal-body">
                        <p>Insira os detalhes do seu cartão de crédito.</p>
                        <!-- Exemplo de campos de pagamento -->
                        <div class="mb-3">
                            <label for="cartaoNumero" class="form-label">Número do Cartão</label>
                            <input type="text" class="form-control" id="cartaoNumero" placeholder="1234 5678 9101 1121">
                        </div>
                        <div class="mb-3">
                            <label for="cartaoValidade" class="form-label">Validade</label>
                            <input type="text" class="form-control" id="cartaoValidade" placeholder="MM/AA">
                        </div>
                        <div class="mb-3">
                            <label for="cartaoCVV" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cartaoCVV" placeholder="123">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" form="confirmForm" name="confirmarCompra"
                            class="btn btn-primary">Confirmar
                            Compra</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de PIX -->
        <div class="modal fade" id="pixModal" tabindex="-1" aria-labelledby="pixModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pixModalLabel">Pagamento via PIX</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    </div>
                    <div class="modal-body">
                        <p>Use o código abaixo para realizar o pagamento via PIX:</p>
                        <div class="mb-3">
                            <p><strong>Código PIX:</strong> 1234567890</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" form="confirmForm" name="confirmarCompra"
                            class="btn btn-primary">Confirmar
                            Compra</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Boleto Bancário -->
        <div class="modal fade" id="boletoModal" tabindex="-1" aria-labelledby="boletoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="boletoModalLabel">Pagamento via Boleto Bancário</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    </div>
                    <div class="modal-body">
                        <p>Gere o boleto para efetuar o pagamento.</p>
                        <div class="mb-3">
                            <p><strong>Link para Boleto:</strong> <a href="boleto.htm">Clique aqui para gerar seu
                                    boleto</a></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="submit" form="confirmForm" name="confirmarCompra"
                            class="btn btn-primary">Confirmar
                            Compra</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('proximo').addEventListener('click', function () {
                const metodoSelecionado = document.querySelector('input[name="metodoPagamento"]:checked');
                if (metodoSelecionado) {
                    $('#confirmModal').modal('hide');
                    const metodoId = metodoSelecionado.id + 'Modal';
                    if (document.getElementById(metodoId)) {
                        $('#' + metodoId).modal('show');
                    } else {
                        alert('Erro: Modal para o método selecionado não encontrado.');
                    }
                } else {
                    alert('Por favor, selecione um método de pagamento.');
                }
            });

            // Função para remover um produto do carrinho sem recarregar a página
            function removerProduto(codigoProduto) {
                if (confirm("Você tem certeza que deseja remover este produto do carrinho?")) {
                    // Fazer a requisição ao servidor para remover o item
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", "carrinho.php?remover=" + codigoProduto, true);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            // A remoção foi feita, atualizar a página ou o carrinho
                            alert("Produto removido do carrinho.");
                            location.reload(); // Recarregar a página para refletir a mudança
                        }
                    };
                    xhr.send();
                }
            }
        </script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>