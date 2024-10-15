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

    <title>CRUD Usuário</title>
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
                    <h2>Controle de Produção <button id="addBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Adicionar Produção</button></h2>
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
                                <h2>Adicionar Novo</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="producao.php" method="POST">
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="codPedido" name="codPedido" class="form-control" placeholder="Código Pedido" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="codFinanceiro" name="codFinanceiro" class="form-control" placeholder="Código Financeiro" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="date" id="dataSta" name="dataSta" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="date" id="dataEnd" name="dataEnd" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="quantidade" name="quantidade" class="form-control" placeholder="Quantidade" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" step=1 id="descricao" name="descricao" class="form-control" placeholder="Descricao">
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" name="status">
                                            <option value="Pendente">Pendente</option>
                                            <option value="Em Produção">Em Produção</option>
                                            <option value="Pronto">Pronto</option>
                                            <option value="Entregue">Entregue</option>
                                            <option value="Atraso">Atraso</option>
                                        </select>
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
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>Adicionar Novo</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="producao.php" method="POST">
                                    <input type="hidden" id="edit_codigo" name="codigo">
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="edit_codPedido" name="codPedido" class="form-control" placeholder="Código Pedido" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="edit_codFinanceiro" name="codFinanceiro" class="form-control" placeholder="Código Financeiro" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="date" id="edit_dataSta" name="dataSta" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="date" id="edit_dataEnd" name="dataEnd" class="form-control" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="edit_quantidade" name="quantidade" class="form-control" placeholder="Quantidade" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" step=1 id="edit_descricao" name="descricao" class="form-control" placeholder="Descricao">
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" id="edit_status" name="status">
                                            <option value="Pendente">Pendente</option>
                                            <option value="Em Produção">Em Produção</option>
                                            <option value="Pronto">Pronto</option>
                                            <option value="Entregue">Entregue</option>
                                            <option value="Atraso">Atraso</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success" id="editar" name="editar">Editar</button>
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
                                <form class="form-group well" action="producao.php" method="POST">
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="delete_codigo" name="codigo" class="form-control">
                                    </div>
                                    <p>Realmente deseja <a class="text-danger">EXCLUIR PERMANENTEMENTE</a> este registro?</p>
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
                        <td><b>Código Pedido</b></td>
                        <td><b>Código Financeiro</b></td>
                        <td><b>Data Incial</b></td>
                        <td><b>Data Limite</b></td>
                        <td><b>Quantidade</b></td>
                        <td><b>Descricao</b></td>
                        <td><b>Status</b></td>
                        <td><b>Operação</b></td>
                    </tr>

                    <?php
                    // Cadastrar novo produto
                    if (isset($_POST["cadastrar"])) {
                        $codPedido = $_POST['codPedido'];
                        $codFinanceiro = $_POST['codFinanceiro'];
                        $dataSta = $_POST['dataSta'];
                        $dataEnd = $_POST['dataEnd'];
                        $quantidade = $_POST['quantidade'];
                        $descricao = !empty($_POST['descricao']) ? $_POST['descricao'] : 'Sem descrição'; // Verifica se a descrição está vazia
                        $status = $_POST['status'];

                        $sql = "INSERT INTO producao (codPedido, codFinanceiro, dataSta, dataEnd, quantidade, descricao, status) VALUES ('$codPedido', '$codFinanceiro', '$dataSta', '$dataEnd', '$quantidade', '$descricao', '$status')";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Produto adicionado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao adicionar: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    // Editar usuário
                    if (isset($_POST["editar"])) {
                        $codigo = $_POST['codigo'];
                        $codPedido = $_POST['codPedido'];
                        $codFinanceiro = $_POST['codFinanceiro'];
                        $dataSta = $_POST['dataSta'];
                        $dataEnd = $_POST['dataEnd'];
                        $quantidade = $_POST['quantidade'];
                        $descricao = $_POST['descricao'];
                        $status = $_POST['status'];

                        $sql = "UPDATE producao SET codPedido='$codPedido', codFinanceiro='$codFinanceiro', dataSta='$dataSta', dataEnd='$dataEnd', quantidade='$quantidade', descricao='$descricao', status='$status' WHERE codigo='$codigo'";

                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Registro atualizado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao atualizar registro: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    // Excluir usuário
                    if (isset($_POST['confirmar_excluir'])) {
                        $codigo = $_POST['codigo'];

                        $sql = "DELETE FROM producao WHERE codigo = '$codigo'";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Excluído com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao excluir: " . mysqli_error($conectar) . "');</script>";
                        }

                        echo "<script>location.href='producao.php';</script>";
                    }

                    // Visualização da tabela                   
                    $consulta = "SELECT * FROM producao";
                    if ($search) {
                        $consulta .= " WHERE codPedido LIKE '%$search%' OR codFinanceiro LIKE '%$search%' OR dataEnd LIKE '%$search%' OR dataSta LIKE '%$search%' OR status LIKE '%$search%'";
                    }

                    $resultado = mysqli_query($conectar, $consulta);

                    while ($dados = mysqli_fetch_array($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $dados['codigo'] . "</td>";
                        echo "<td>" . $dados['codPedido'] . "</td>";
                        echo "<td>" . $dados['codFinanceiro'] . "</td>";
                        echo "<td>" . $dados['dataSta'] . "</td>";
                        echo "<td>" . $dados['dataEnd'] . "</td>";
                        echo "<td>" . $dados['quantidade'] . "</td>";
                        echo "<td>" . $dados['descricao'] . "</td>";
                        echo "<td>" . $dados['status'] . "</td>";
                        echo "<td>
                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModalEditar' 
                        onclick=\"fillEditModal('{$dados['codigo']}', '{$dados['codPedido']}', '{$dados['codFinanceiro']}', '{$dados['dataSta']}', '{$dados['dataEnd']}', '{$dados['quantidade']}', '{$dados['descricao']}', '{$dados['status']}')\">
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
            function fillEditModal(codigo, codPedido, codFinanceiro, dataSta, dataEnd, quantidade, descricao, status) {
                document.getElementById('edit_codigo').value = codigo;
                document.getElementById('edit_codPedido').value = codPedido;
                document.getElementById('edit_codFinanceiro').value = codFinanceiro;
                document.getElementById('edit_dataSta').value = dataSta;
                document.getElementById('edit_dataEnd').value = dataEnd;
                document.getElementById('edit_quantidade').value = quantidade;
                document.getElementById('edit_descricao').value = descricao;
                document.getElementById('edit_status').value = status;
            }

            function fillDeleteModal(codigo) {
                document.getElementById('delete_codigo').value = codigo;
            }
        </script>

</body>

</html>