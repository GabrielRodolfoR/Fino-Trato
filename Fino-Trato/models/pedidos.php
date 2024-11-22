<?php
include('auth.php');

$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conectar, $_POST['search']);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .middleTop {
            width: 500px;
        }

        .rounded-image {
            border-radius: 50%;
            width: 60px;
            height: 60px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <title>Gerenciamento Pedidos</title>
</head>

<body>
    <div class="top">
        <div class="topUp">
            <div class="leftTop">
                <div class="logo">
                    <a href="gerencia.php"><img src="img/adm_logo.png" width=150 height=75></a>
                </div>
            </div>
            <div class="middleTop"></div>
            <div class="rightTop">
                <div class="topUserImg">
                    <a href="perfil.php">
                        <img src="<?php echo isset($_SESSION['imagem']) ? $_SESSION['imagem'] : 'img/lightmdUser.png'; ?>" class="rounded-image">
                    </a>
                </div>
            </div>
        </div>
        <div class="topDown">
            <div class="navigation">
                <a href="usuarios.php">Usuários</a>
                <a href="estoque.php">Estoque</a>
                <a href="pedidos.php">Pedidos</a>
                <a href="financeiro.php">Financeiro</a>
                <a href="producao.php">Produção</a>
                <a href="entrega.php">Entrega</a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col md-12">
                <div class="jumbotron p-4">
                    <h2>Gerenciamento de Pedidos <button id="addBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Adicionar Pedido</button></h2>
                </div>

                <!-- Formulário de Pesquisa -->
                <form method="POST" action="">
                    <div class="input-group mb-4 col-md-4">
                        <input class="form-control" name="search" id="exampleDataList" placeholder="Pesquisar" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-info">Pesquisar</button>
                    </div>
                </form>

                <!--Modal Cadastrar-->
                <div class="modal fade bd-example-modal-lg" id="myModalCadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>Adicionar Novo Pedido</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="pedidos.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <input type="number" step="1" id="nomeUsuario" name="nomeUsuario" class="form-control" placeholder="Nome Usuário" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="madeira" name="madeira" class="form-control" placeholder="Madeira" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="descricao" name="descricao" class="form-control" placeholder="Descrição">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" id="imagem" name="imagem" class="form-control" required>
                                    </div>
                                    <!--Parte digitar valores-->
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">cm</span>
                                        <input type="number" step="0.01" id="comprimento" name="comprimento" class="form-control" placeholder="Comprimento" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">cm</span>
                                        <input type="number" step="0.01" id="largura" name="largura" class="form-control" placeholder="Largura" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">cm</span>
                                        <input type="number" step="0.01" id="espessura" name="espessura" class="form-control" placeholder="Espessura" required>
                                    </div>

                                    <button type="submit" class="btn btn-success" id="cadastrar" name="cadastrar">Cadastrar</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal Editar-->
                <div class="modal fade bd-example-modal-lg" id="myModalEditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>Editar Registro</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3">
                                <form class="form-group well" action="pedidos.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="edit_codigo" name="codigo">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_nomeUsuario" name="nomeUsuario" class="form-control" placeholder="Nome Usuário" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_madeira" name="madeira" class="form-control" placeholder="Madeira" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_descricao" name="descricao" class="form-control" placeholder="Descriçao" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" id="edit_imagem" name="imagem" class="form-control">
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">cm</span>
                                        <input type="number" step="0.01" id="edit_comprimento" name="comprimento" class="form-control" placeholder="Comprimento" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">cm</span>
                                        <input type="number" step="0.01" id="edit_largura" name="largura" class="form-control" placeholder="Largura" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">cm</span>
                                        <input type="number" step="0.01" id="edit_espessura" name="espessura" class="form-control" placeholder="Espessura" required>
                                    </div>

                                    <button type="submit" class="btn btn-success" id="editar" name="editar">Salvar Alterações</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Excluir -->
                <div class="modal fade" id="myModalExcluir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>Excluir Pedido</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="pedidos.php" method="POST">
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="delete_codigo" name="codigo" class="form-control">
                                    </div>
                                    <p>Realmente deseja <a class="text-danger">EXCLUIR PERMANENTEMENTE</a> este pedido?</p>
                                    <button type="submit" class="btn btn-danger" id="confirmar_excluir" name="confirmar_excluir">Excluir</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Table / Visualizar-->
                <table class="table table-hover table-bordered table-striped" bordercolor="gray" class="table table-striped">
                    <tr>
                        <td><b>Código</b></td>
                        <td><b>Nome Usuário</b></td>
                        <td><b>Madeira</b></td>
                        <td><b>Descrição</b></td>
                        <td><b>Imagem</b></td>
                        <td><b>Comprimento</b></td>
                        <td><b>Largura</b></td>
                        <td><b>Espessura</b></td>
                        <td><b>Operação</b></td>
                    </tr>

                    <?php

                    // Cadastrar novo pedido
                    if (isset($_POST["cadastrar"])) {
                        $nomeUsuario = $_POST['nomeUsuario'];
                        $madeira = $_POST['madeira'];
                        $descricao = !empty($_POST['descricao']) ? $_POST['descricao'] : 'Sem descrição'; // Verifica se a descrição está vazia
                        $comprimento = $_POST['comprimento'];
                        $largura = $_POST['largura'];
                        $espessura = $_POST['espessura'];

                        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                            $novoNome = uniqid() . '.' . $extensao;
                            $destino = 'imageOrder/' . $novoNome;
                            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
                        } else {
                            $destino = 'NULL';
                        }

                        $sql = "INSERT INTO pedido (nomeUsuario, madeira, descricao, imagem, comprimento, largura, espessura) VALUES ('$nomeUsuario', '$madeira', '$descricao', '$destino', '$comprimento', '$largura', '$espessura')";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Pedido adicionado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao adicionar: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    // Editar Estoque
                    if (isset($_POST["editar"])) {
                        $codigo = $_POST['codigo'];
                        $nomeUsuario = $_POST['nomeUsuario'];
                        $madeira = $_POST['madeira'];
                        $descricao = $_POST['descricao'];
                        $comprimento = $_POST['comprimento'];
                        $largura = $_POST['largura'];
                        $espessura = $_POST['espessura'];

                        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                            $novoNome = uniqid() . '.' . $extensao;
                            $destino = 'imageUser/' . $novoNome;
                            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

                            // Atualiza com a nova imagem
                            $sql = "UPDATE pedido SET nomeUsuario='$nomeUsuario', madeira='$madeira', descricao='$descricao', imagem='$destino', comprimento='$comprimento', largura='$largura', espessura='$espessura' WHERE codigo=$codigo";
                        } else {
                            // Mantém a imagem antiga se nenhuma nova foi enviada
                            $sql = "UPDATE pedido SET nomeUsuario='$nomeUsuario', madeira='$madeira', descricao='$descricao', comprimento='$comprimento', largura='$largura', espessura='$espessura' WHERE codigo=$codigo";
                        }

                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Pedido atualizado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao atualizar Pedido: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    // Excluir Pedido
                    if (isset($_POST['confirmar_excluir'])) {
                        $codigo = $_POST['codigo'];

                        $sql = "DELETE FROM pedido WHERE codigo = '$codigo'";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Excluído com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao excluir: " . mysqli_error($conectar) . "');</script>";
                        }

                        echo "<script>location.href='pedidos.php';</script>";
                    }
                    // Visualização da tabela                   
                    $consulta = "SELECT * FROM pedido";
                    if ($search) {
                        $consulta .= " WHERE madeira LIKE '%$search%' OR descricao LIKE '%$search%'";
                    }

                    $resultado = mysqli_query($conectar, $consulta);

                    while ($dados = mysqli_fetch_array($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $dados['codigo'] . "</td>";
                        echo "<td>" . $dados['nomeUsuario'] . "</td>";
                        echo "<td>" . $dados['madeira'] . "</td>";
                        echo "<td>" . $dados['descricao'] . "</td>";
                        echo "<td><img src='" . $dados['imagem'] . "' width='100' height='100'></td>";
                        echo "<td>" . $dados['comprimento'] . "</td>";
                        echo "<td>" . $dados['largura'] . "</td>";
                        echo "<td>" . $dados['espessura'] . "</td>";
                        echo "<td>
                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModalEditar' 
                        onclick=\"fillEditModal('{$dados['codigo']}', '{$dados['nomeUsuario']}', '{$dados['madeira']}', '{$dados['descricao']}', 
                        '{$dados['comprimento']}', '{$dados['largura']}', '{$dados['espessura']}')\">
                        Editar</button>

                        <button type='button' class='btn btn-danger' data-toggle='modal' data-target='#myModalExcluir'
                        onclick=\"fillDeleteModal('{$dados['codigo']}')\">
                        Excluir</button>
                    </td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </div>
        </div>

        <script>
            function fillEditModal(codigo, nomeUsuario, madeira, descricao, comprimento, largura, espessura) {
                document.getElementById('edit_codigo').value = codigo;
                document.getElementById('edit_nomeUsuario').value = nomeUsuario;
                document.getElementById('edit_madeira').value = madeira;
                document.getElementById('edit_descricao').value = descricao;
                document.getElementById('edit_comprimento').value = comprimento;
                document.getElementById('edit_largura').value = largura;
                document.getElementById('edit_espessura').value = espessura;
            }

            function fillDeleteModal(codigo) {
                document.getElementById('delete_codigo').value = codigo;
            }
        </script>
</body>

</html>