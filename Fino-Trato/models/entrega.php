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
function formatarCPF($cpf)
{
    return preg_replace('/^(\d{3})(\d{3})(\d{3})(\d{2})$/', '$1.$2.$3-$4', $cpf);
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

    <title>Controle Entrega</title>
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
                    <h2>Controle de Entregas <button id="addBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Adicionar Entrega</button></h2>
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
                                <form class="form-group well" action="entrega.php" method="POST">
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="codUsuario" name="codUsuario" class="form-control" placeholder="Código Usuário" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF" required oninput="this.value = formatarCPF(this.value)">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="endereco" name="endereco" class="form-control" placeholder="Endereço" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="produto" name="produto" class="form-control" placeholder="Produto" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" name="status">
                                            <option value="Pendente">Pendente</option>
                                            <option value="Embalado">Embalado</option>
                                            <option value="A caminho">A caminho</option>
                                            <option value="Entregue">Entregue</option>
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
                                <h2>Editar entrega</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3 ">
                                <form class="form-group well" action="entrega.php" method="POST">
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="edit_codigo" name="codigo">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="number" step=1 id="edit_codUsuario" name="codUsuario" class="form-control" placeholder="Código Usuário" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_cpf" name="cpf" class="form-control" placeholder="CPF" required oninput="this.value = formatarCPF(this.value)">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_endereco" name="endereco" class="form-control" placeholder="Endereço" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_produto" name="produto" class="form-control" placeholder="Produto" required>
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" id="edit_status" name="status">
                                            <option value="Pendente">Pendente</option>
                                            <option value="Embalado">Embalado</option>
                                            <option value="A caminho">A caminho</option>
                                            <option value="Entregue">Entregue</option>
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
                                <form class="form-group well" action="entrega.php" method="POST">
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
                        <td><b>Código Usuário</b></td>
                        <td><b>CPF</b></td>
                        <td><b>Endereço</b></td>
                        <td><b>Produto</b></td>
                        <td><b>Status</b></td>
                        <td><b>Operação</b></td>
                    </tr>

                    <?php
                    // Cadastrar novo usuário
                    if (isset($_POST["cadastrar"])) {
                        $codUsuario = $_POST['codUsuario'];

                        // Remover formatação do CPF
                        $cpf = preg_replace('/\D/', '', $_POST['cpf']); // Remove tudo que não é número
                        $endereco = $_POST['endereco'];
                        $produto = $_POST['produto'];
                        $status = $_POST['status'];

                        $sql = "INSERT INTO entrega (codUsuario, cpf, endereco, produto, status) VALUES ('$codUsuario', '$cpf', '$endereco', '$produto', '$status')";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao cadastrar: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    // Editar usuário
                    if (isset($_POST["editar"])) {
                        $codigo = $_POST['codigo'];
                        $codUsuario = $_POST['codUsuario'];

                        // Remover formatação do CPF
                        $cpf = preg_replace('/\D/', '', $_POST['cpf']); // Remove tudo que não é número
                        $endereco = $_POST['endereco'];
                        $produto = $_POST['produto'];
                        $status = $_POST['status'];

                        $sql = "UPDATE entrega SET codUsuario='$codUsuario', cpf='$cpf', endereco='$endereco', produto='$produto', status='$status' WHERE codigo=$codigo";

                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Registro atualizado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao atualizar registro: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    if (isset($_POST['confirmar_excluir'])) {
                        $codigo = $_POST['codigo'];

                        $sql = "DELETE FROM entrega WHERE codigo = '$codigo'";
                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Excluído com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao excluir: " . mysqli_error($conectar) . "');</script>";
                        }

                        echo "<script>location.href='entrega.php';</script>";
                    }

                    // Visualização da tabela                   
                    $consulta = "SELECT * FROM entrega";
                    if ($search) {
                        $consulta .= " WHERE nome LIKE '%$search%' OR email LIKE '%$search%' OR telefone LIKE '%$search%'";
                    }

                    $resultado = mysqli_query($conectar, $consulta);

                    while ($dados = mysqli_fetch_array($resultado)) {
                        $cpfFormatado = formatarCPF($dados['cpf']); // Formatar CPF apenas para exibição

                        echo "<tr>";
                        echo "<td>" . $dados['codigo'] . "</td>";
                        echo "<td>" . $dados['codUsuario'] . "</td>";
                        echo "<td>" . $cpfFormatado . "</td>"; // Exibir CPF formatado
                        echo "<td>" . $dados['endereco'] . "</td>";
                        echo "<td>" . $dados['produto'] . "</td>";
                        echo "<td>" . $dados['status'] . "</td>";
                        echo "<td>
                            <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#myModalEditar' 
                            onclick=\"fillEditModal('{$dados['codigo']}', '{$dados['codUsuario']}', '{$dados['cpf']}', '{$dados['endereco']}', '{$dados['produto']}', '{$dados['status']}')\">
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
            function fillEditModal(codigo, codUsuario, cpf, endereco, produto, status) {
                document.getElementById('edit_codigo').value = codigo;
                document.getElementById('edit_codUsuario').value = codUsuario;
                document.getElementById('edit_cpf').value = cpf;
                document.getElementById('edit_endereco').value = endereco;
                document.getElementById('edit_produto').value = produto;
                document.getElementById('edit_status').value = status;
            }

            function fillDeleteModal(codigo) {
                document.getElementById('delete_codigo').value = codigo;
                $('#myModalExcluir').modal('show');
            }

            function formatarCPF(cpf) {
                return cpf
                    .replace(/\D/g, '') // Remove caracteres não numéricos
                    .replace(/^(\d{3})(\d)/, '$1.$2') // Adiciona o primeiro ponto
                    .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3') // Adiciona o segundo ponto
                    .replace(/\.(\d{3})(\d)/, '.$1-$2') // Adiciona o hífen
                    .replace(/(-\d{2})\d+$/, '$1'); // Limita a 11 dígitos
            }
        </script>
</body>

</html>