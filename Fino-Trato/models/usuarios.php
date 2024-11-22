<?php
include('auth.php');

$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

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
function formatarTelefone($telefone)
{
    return preg_replace('/^(\d{2})(\d{5})(\d{4})$/', '($1) $2-$3', $telefone);
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

    <title>Gerenciamento Usuário</title>
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
                    <h2>Gerenciamento de Usuários <button id="addBtn" type="button" class="btn btn-success" data-toggle="modal" data-target="#myModalCadastrar">Adicionar Usuário</button></h2>
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
                                <h2>Adicionar Novo Registro</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3">
                                <form class="form-group well" action="usuarios.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <input type="text" id="nome" name="nome" class="form-control" placeholder="Nome" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="cpf" name="cpf" class="form-control" placeholder="CPF" required oninput="this.value = formatarCPF(this.value)">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" step="1" id="telefone" name="telefone" class="form-control" placeholder="Telefone" required oninput="this.value = formatarTelefone(this.value)">
                                    </div>

                                    <div class="input-group mb-3">
                                        <input type="text" id="endereco" name="endereco" class="form-control" placeholder="CEP" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" id="imagem" name="imagem" class="form-control">
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" name="status">
                                            <option value="Usuário">Usuário</option>
                                            <option value="Administrador">Administrador</option>
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
                    <div class="modal-dialog modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>Editar Registro</h2>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body md-3">
                                <form class="form-group well" action="usuarios.php" method="POST" enctype="multipart/form-data">
                                    <div class="input-group mb-3">
                                        <input type="hidden" id="edit_codigo" name="codigo">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_nome" name="nome" class="form-control" placeholder="Nome" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="email" id="edit_email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_cpf" name="cpf" class="form-control" placeholder="CPF" required oninput="this.value = formatarCPF(this.value)">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" step=1 id="edit_telefone" name="telefone" class="form-control" placeholder="Telefone" required oninput="this.value = formatarTelefone(this.value)">
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" id="edit_endereco" name="endereco" class="form-control" placeholder="CEP" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" id="edit_imagem" name="imagem" class="form-control">
                                    </div>
                                    <div class="input-group mb-4">
                                        <select class="form-control" id="edit_status" name="status">
                                            <option value="Usuário">Usuário</option>
                                            <option value="Administrador">Administrador</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success" id="editar" name="editar">Salvar Alterações</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Table / Visualizar-->
                <table class="table table-hover table-bordered table-striped">
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>CEP</th>
                        <th>Imagem</th>
                        <th>Status</th>
                        <th>Operação</th>
                    </tr>

                    <?php
                    // Cadastrar novo usuário
                    if (isset($_POST["cadastrar"])) {
                        $nome = $_POST['nome'];
                        $email = $_POST['email'];
                        $cpf = preg_replace('/\D/', '', $_POST['cpf']); // Remove não numéricos
                        $telefone = preg_replace('/\D/', '', $_POST['telefone']); // Remove não numéricos
                        $endereco = $_POST['endereco'];
                        $senha = md5($_POST['senha']);
                        $status = $_POST['status'];

                        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                            $novoNome = uniqid() . '.' . $extensao;
                            $destino = 'imageUser/' . $novoNome;
                            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
                        } else {
                            $destino = 'NULL';
                        }

                        $sql = "INSERT INTO usuario (nome, email, cpf, telefone, endereco, senha, imagem, status) VALUES ('$nome', '$email', '$cpf', '$telefone', '$endereco', '$senha', '$destino', '$status')";
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
                        $nome = $_POST['nome'];
                        $email = $_POST['email'];
                        $cpf = preg_replace('/\D/', '', $_POST['cpf']); // Remove não numéricos
                        $telefone = preg_replace('/\D/', '', $_POST['telefone']); // Remove não numéricos
                        $endereco = $_POST['endereco'];
                        $status = $_POST['status'];

                        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
                            $novoNome = uniqid() . '.' . $extensao;
                            $destino = 'imageUser/' . $novoNome;
                            move_uploaded_file($_FILES['imagem']['tmp_name'], $destino);
                            $sql = "UPDATE usuario SET nome='$nome', email='$email', cpf='$cpf', telefone='$telefone', endereco='$endereco', imagem='$destino', status='$status' WHERE codigo=$codigo";
                        } else {
                            $sql = "UPDATE usuario SET nome='$nome', email='$email', cpf='$cpf', telefone='$telefone', endereco='$endereco', status='$status' WHERE codigo=$codigo";
                        }

                        $resultado = mysqli_query($conectar, $sql);

                        if ($resultado) {
                            echo "<script>alert('Registro atualizado com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao atualizar registro: " . mysqli_error($conectar) . "');</script>";
                        }
                    }

                    // Visualização da tabela                   
                    $consulta = "SELECT * FROM usuario";
                    if ($search) {
                        $consulta .= " WHERE nome LIKE '%$search%' OR email LIKE '%$search%' OR endereco LIKE '%$search%' ";
                    }

                    $resultado = mysqli_query($conectar, $consulta);

                    while ($dados = mysqli_fetch_array($resultado)) {
                        $cpfFormatado = formatarCPF($dados['cpf']);
                        $telefoneFormatado = formatarTelefone($dados['telefone']);

                        echo "<tr>";
                        echo "<td>" . $dados['codigo'] . "</td>";
                        echo "<td>" . $dados['nome'] . "</td>";
                        echo "<td>" . $dados['email'] . "</td>";
                        echo "<td>" . $cpfFormatado . "</td>"; // Exibir CPF formatado
                        echo "<td>" . $telefoneFormatado . "</td>"; // Exibir Telefone formatado
                        echo "<td>" . $dados['endereco'] . "</td>";
                        echo "<td><img src='" . $dados['imagem'] . "' width='100' height='100'></td>";
                        echo "<td>" . $dados['status'] . "</td>";
                        echo "<td>
                                <button type='button' class='btn btn-warning' data-toggle='modal' data-target='#myModalEditar' 
                                onclick=\"fillEditModal('{$dados['codigo']}', '{$dados['nome']}', '{$dados['email']}', '{$dados['cpf']}', '{$dados['telefone']}', '{$dados['endereco']}', '{$dados['imagem']}', '{$dados['status']}')\">
                                Editar Permições</button>
                            </td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </div>
        </div>

        <script>
            function fillEditModal(codigo, nome, email, cpf, telefone, endereco, imagem, status) {
                document.getElementById('edit_codigo').value = codigo;
                document.getElementById('edit_nome').value = nome;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_cpf').value = cpf;
                document.getElementById('edit_telefone').value = telefone;
                document.getElementById('edit_endereco').value = endereco;
                document.getElementById('edit_status').value = status;
            }

            function formatarCPF(cpf) {
                return cpf
                    .replace(/\D/g, '') // Remove caracteres não numéricos
                    .replace(/^(\d{3})(\d)/, '$1.$2') // Adiciona o primeiro ponto
                    .replace(/^(\d{3})\.(\d{3})(\d)/, '$1.$2.$3') // Adiciona o segundo ponto
                    .replace(/\.(\d{3})(\d)/, '.$1-$2') // Adiciona o hífen
                    .replace(/(-\d{2})\d+$/, '$1'); // Limita a 11 dígitos
            }

            function formatarTelefone(telefone) {
                return telefone
                    .replace(/\D/g, '') // Remove caracteres não numéricos
                    .replace(/^(\d{2})(\d)/, '($1) $2') // Adiciona parênteses no DDD
                    .replace(/(\d{5})(\d)/, '$1-$2') // Adiciona o hífen no número
                    .replace(/(-\d{4})\d+?$/, '$1'); // Limita a 11 dígitos
            }
        </script>
</body>

</html>