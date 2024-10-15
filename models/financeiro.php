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

    <title>Controle Financeiro</title>
</head>

<body>
    <div class="top">
        <div class="topUp">
            <div class="leftTop">
                <div class="logo">
                    <a href="home.php"><img src="img/adm_logo.png" width=150 height=75></a>
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
                    <h2>Controle do Financeiro
                        <button id="addBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Adicionar Finança</button>
                        <a href="relatorio.php" class="btn btn-primary">Relatório</a>
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
                                <form class="form-group well" action="financeiro.php" method="POST">
                                    <div class="input-group mb-3">
                                        <input type="number" step="1" id="codPedido" name="codPedido" class="form-control" placeholder="Código Pedido" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step="1" id="codUsuario" name="codUsuario" class="form-control" placeholder="Código Usuário" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="custo" name="custo" class="form-control" placeholder="Custo" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="precoEnd" name="precoEnd" class="form-control" placeholder="Preço Final" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="lucro" name="lucro" class="form-control" placeholder="Lucro" required readonly>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="date" id="data" name="data" class="form-control" placeholder="Data" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" name="status">
                                            <option value="Em aguardo">Em aguardo</option>
                                            <option value="Aprovado">Aprovado</option>
                                            <option value="Cancelado">Cancelado</option>
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
                                <h2>Editar Financeiro</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="financeiro.php" method="POST">
                                    <input type="hidden" id="edit_codigo" name="codigo">
                                    <div class="input-group mb-3">
                                        <input type="number" step="1" id="edit_codPedido" name="codPedido" class="form-control" placeholder="Código Pedido" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step="1" id="edit_codUsuario" name="codUsuario" class="form-control" placeholder="Código Usuário" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="edit_custo" name="custo" class="form-control" placeholder="Custo" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="edit_precoEnd" name="precoEnd" class="form-control" placeholder="Preço Final" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" step="0.01" id="edit_lucro" name="lucro" class="form-control" placeholder="Lucro" required readonly>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="date" id="edit_data" name="data" class="form-control" placeholder="Data" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" id="edit_status" name="status">
                                            <option value="Em aguardo">Em aguardo</option>
                                            <option value="Aprovado">Aprovado</option>
                                            <option value="Cancelado">Cancelado</option>
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
                                <h2>Excluir Financeiro</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Você tem certeza que deseja excluir este registro?</p>
                                <input type="hidden" id="excluir_codigo" name="codigo">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <button type="button" class="btn btn-danger" id="confirmarExcluir">Excluir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mostrar tabela-->
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>Código</th>
                        <th>Código Pedido</th>
                        <th>Código Usuário</th>
                        <th>Custo</th>
                        <th>Preço Final</th>
                        <th>Lucro</th>
                        <th>Data</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                    <?php
                    $sql = "SELECT * FROM financeiro WHERE codPedido LIKE '%$search%' OR codUsuario LIKE '%$search%'";
                    $resultado = mysqli_query($conectar, $sql);

                    while ($linha = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>
                                <td>{$linha['codigo']}</td>
                                <td>{$linha['codPedido']}</td>
                                <td>{$linha['codUsuario']}</td>
                                <td>R$ " . number_format($linha['custo'], 2, ',', '.') . "</td>
                                <td>R$ " . number_format($linha['precoEnd'], 2, ',', '.') . "</td>
                                <td>R$ " . number_format($linha['precoEnd'] - $linha['custo'], 2, ',', '.') . "</td>
                                <td>{$linha['data']}</td>
                                <td>{$linha['status']}</td>
                                <td>
                                    <button class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar' onclick='fillEditModal({$linha['codigo']}, {$linha['codPedido']}, {$linha['codUsuario']}, {$linha['custo']}, {$linha['precoEnd']}, \"{$linha['data']}\", \"{$linha['status']}\")'>Editar</button>
                                    <button class='btn btn-danger' data-toggle='modal' data-target='#myModalExcluir' onclick='document.getElementById(\"excluir_codigo\").value={$linha['codigo']}'>Excluir</button>
                                </td>
                            </tr>";
                    }
                    ?>
                </table>

                <?php
                if (isset($_POST['cadastrar'])) {
                    $codPedido = $_POST['codPedido'];
                    $codUsuario = $_POST['codUsuario'];
                    $custo = $_POST['custo'];
                    $precoEnd = $_POST['precoEnd'];
                    $data = $_POST['data'];
                    $status = $_POST['status'];

                    $sql = "INSERT INTO financeiro (codPedido, codUsuario, custo, precoEnd, data, status) VALUES ('$codPedido', '$codUsuario', '$custo', '$precoEnd', '$data', '$status')";
                    if (mysqli_query($conectar, $sql)) {
                        echo "<script>alert('Registro cadastrado com sucesso!');</script>";
                    } else {
                        echo "<script>alert('Erro ao cadastrar registro: " . mysqli_error($conectar) . "');</script>";
                    }
                }

                if (isset($_POST['editar'])) {
                    $codigo = $_POST['codigo'];
                    $codPedido = $_POST['codPedido'];
                    $codUsuario = $_POST['codUsuario'];
                    $custo = $_POST['custo'];
                    $precoEnd = $_POST['precoEnd'];
                    $data = $_POST['data'];
                    $status = $_POST['status'];

                    $sql = "UPDATE financeiro SET codPedido='$codPedido', codUsuario='$codUsuario', custo='$custo', precoEnd='$precoEnd', data='$data', status='$status' WHERE codigo='$codigo'";
                    if (mysqli_query($conectar, $sql)) {
                        echo "<script>alert('Registro editado com sucesso!');</script>";
                    } else {
                        echo "<script>alert('Erro ao editar registro: " . mysqli_error($conectar) . "');</script>";
                    }
                }

                if (isset($_POST['excluir'])) {
                    $codigo = $_POST['codigo'];
                    $sql = "DELETE FROM financeiro WHERE codigo='$codigo'";
                    if (mysqli_query($conectar, $sql)) {
                        echo "<script>alert('Registro excluído com sucesso!');</script>";
                    } else {
                        echo "<script>alert('Erro ao excluir registro: " . mysqli_error($conectar) . "');</script>";
                    }
                }
                ?>

                <script>
                    function calcularLucro() {
                        const custo = parseFloat(document.getElementById('custo').value) || 0;
                        const precoEnd = parseFloat(document.getElementById('precoEnd').value) || 0;
                        const lucro = precoEnd - custo;
                        document.getElementById('lucro').value = lucro.toFixed(2); // Atualiza o campo lucro
                    }

                    document.getElementById('custo').addEventListener('input', calcularLucro);
                    document.getElementById('precoEnd').addEventListener('input', calcularLucro);

                    // Repetir para o modal de editar
                    function fillEditModal(codigo, codPedido, codUsuario, custo, precoEnd, data, status) {
                        document.getElementById('edit_codigo').value = codigo;
                        document.getElementById('edit_codPedido').value = codPedido;
                        document.getElementById('edit_codUsuario').value = codUsuario;
                        document.getElementById('edit_custo').value = custo;
                        document.getElementById('edit_precoEnd').value = precoEnd;

                        // Calcular lucro ao editar
                        const lucro = precoEnd - custo;
                        document.getElementById('edit_lucro').value = lucro.toFixed(2);

                        document.getElementById('edit_data').value = data;
                        document.getElementById('edit_status').value = status;
                    }

                    document.getElementById('edit_custo').addEventListener('input', function() {
                        const custo = parseFloat(this.value) || 0;
                        const precoEnd = parseFloat(document.getElementById('edit_precoEnd').value) || 0;
                        const lucro = precoEnd - custo;
                        document.getElementById('edit_lucro').value = lucro.toFixed(2);
                    });

                    document.getElementById('edit_precoEnd').addEventListener('input', function() {
                        const precoEnd = parseFloat(this.value) || 0;
                        const custo = parseFloat(document.getElementById('edit_custo').value) || 0;
                        const lucro = precoEnd - custo;
                        document.getElementById('edit_lucro').value = lucro.toFixed(2);
                    });
                </script>
            </div>
        </div>
    </div>
</body>

</html>