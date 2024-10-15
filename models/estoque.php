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
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <title>Controle Estoque</title>
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
                    <a href="login.php"><img src="img/lightmdUser.png" width=40 height=40></a>
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
                    <h2>Controle de Estoque <button id="addBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Adicionar Produto</button></h2>
                </div>

                <!-- Formulário de Pesquisa -->
                <form method="POST" action="">
                    <div class="input-group mb-4 col-md-4">
                        <input class="form-control" name="search" placeholder="Pesquisar" value="<?php echo htmlspecialchars($search); ?>">
                        <button type="submit" class="btn btn-info">Pesquisar</button>
                    </div>
                </form>

                <!--Modal Cadastrar-->
                <div class="modal fade bd-example-modal-lg" id="myModalCadastrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>Adicionar Novo Produto</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="estoque.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-4">
                                        <select class="form-control" name="categoria">
                                            <option value="Frios">Frios</option>
                                            <option value="Churrasco">Churrasco</option>
                                            <option value="Corte">Corte</option>
                                            <option value="Outros">Outros</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="madeira" name="madeira" class="form-control" placeholder="Madeira" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="descricao" name="descricao" class="form-control" placeholder="Descrição" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step="1" id="quantidade" name="quantidade" class="form-control" placeholder="Quantidade" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="preco" name="preco" class="form-control" placeholder="Preço" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" id="imagem" name="imagem" class="form-control">
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
                                <h2>Editar Produto</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3">
                                <form class="form-group well" action="estoque.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="edit_codigo" name="codigo">
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" id="edit_categoria" name="categoria">
                                            <option value="Frios">Frios</option>
                                            <option value="Churrasco">Churrasco</option>
                                            <option value="Corte">Corte</option>
                                            <option value="Outros">Outros</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_madeira" name="madeira" class="form-control" placeholder="Madeira" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_descricao" name="descricao" class="form-control" placeholder="Descricao" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step="1" id="edit_quantidade" name="quantidade" class="form-control" placeholder="Quantidade" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="edit_preco" name="preco" class="form-control" placeholder="Preço" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" id="edit_imagem" name="imagem" class="form-control">
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
                                <h2>Excluir Registro</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="estoque.php" method="POST">
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="delete_codigo" name="codigo" class="form-control">
                                    </div>
                                    <p>Realmente deseja <a class="text-danger">EXCLUIR PERMANENTEMENTE</a> este produto?</p>
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
                        <td><b>Codigo</b></td>
                        <td><b>Categoria</b></td>
                        <td><b>Madeira</b></td>
                        <td><b>Descricao</b></td>
                        <td><b>Quantidade</b></td>
                        <td><b>Preço</b></td>
                        <td><b>Imagem</b></td>
                        <td><b>Operação</b></td>
                    </tr>

                    <?php
                    // Cadastrar novo produto
                    if (isset($_POST["cadastrar"])) {
                        $categoria = $_POST['categoria'];
                        $madeira = $_POST['madeira'];
                        $descricao = $_POST['descricao'];
                        $quantidade = $_POST['quantidade'];
                        $preco = $_POST['preco'];

                        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                            $novoNome = uniqid() . '.' . $extensao;
                            $destino = 'imageDone/' . $novoNome;
                            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
                        } else {
                            $destino = 'NULL';
                        }

                        $sql = "INSERT INTO estoque (categoria, madeira, descricao, quantidade, preco, imagem) VALUES ('$categoria', '$madeira', '$descricao', '$quantidade', '$preco', '$destino')";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Produto adicionado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao adicionar: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    // Editar Estoque
                    if (isset($_POST["editar"])) {
                        $codigo = $_POST['codigo'];
                        $categoria = $_POST['categoria'];
                        $madeira = $_POST['madeira'];
                        $descricao = $_POST['descricao'];
                        $quantidade = $_POST['quantidade'];
                        $preco = $_POST['preco'];

                        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                            $novoNome = uniqid() . '.' . $extensao;
                            $destino = 'imageDone/' . $novoNome;
                            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);

                            // Atualiza com a nova imagem
                            $sql = "UPDATE estoque SET categoria='$categoria', madeira='$madeira', descricao='$descricao', quantidade='$quantidade', preco='$preco', imagem='$destino' WHERE codigo=$codigo";
                        } else {
                            // Mantém a imagem antiga se nenhuma nova foi enviada
                            $sql = "UPDATE estoque SET categoria='$categoria', madeira='$madeira', descricao='$descricao', quantidade='$quantidade', preco='$preco' WHERE codigo=$codigo";
                        }

                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Produto atualizado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao atualizar Produto: " . mysqli_error($conectar) . "');</script>";
                        }
                    }


                    // Excluir produto
                    if (isset($_POST['confirmar_excluir'])) {
                        $codigo = $_POST['codigo'];

                        $sql = "DELETE FROM estoque WHERE codigo = '$codigo'";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Excluído com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao excluir: " . mysqli_error($conectar) . "');</script>";
                        }

                        echo "<script>location.href='estoque.php';</script>";
                    }

                    // Visualização da tabela                   
                    $consulta = "SELECT * FROM estoque";
                    if ($search) {
                        $consulta .= " WHERE categoria LIKE '%$search%' OR  madeira LIKE '%$search%' OR descricao LIKE '%$search%'";
                    }

                    $resultado = mysqli_query($conectar, $consulta);

                    while ($dados = mysqli_fetch_array($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $dados['codigo'] . "</td>";
                        echo "<td>" . $dados['categoria'] . "</td>";
                        echo "<td>" . $dados['madeira'] . "</td>";
                        echo "<td>" . $dados['descricao'] . "</td>";
                        echo "<td>" . $dados['quantidade'] . "</td>";
                        echo "<td>" . $dados['preco'] . "</td>";
                        echo "<td><img src='" . $dados['imagem'] . "' width='100' height='100'></td>";
                        echo "<td>
                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModalEditar' 
                        onclick=\"fillEditModal('{$dados['codigo']}', '{$dados['categoria']}', '{$dados['madeira']}', '{$dados['descricao']}', '{$dados['quantidade']}', '{$dados['preco']}')\">
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
            function fillEditModal(codigo, categoria, madeira, descricao, quantidade, preco, imagem) {
                document.getElementById('edit_codigo').value = codigo;
                document.getElementById('edit_categoria').value = categoria;
                document.getElementById('edit_madeira').value = madeira;
                document.getElementById('edit_descricao').value = descricao;
                document.getElementById('edit_quantidade').value = quantidade;
                document.getElementById('edit_preco').value = preco;
            }

            function fillDeleteModal(codigo) {
                document.getElementById('delete_codigo').value = codigo;
            }
        </script>

</body>

</html>