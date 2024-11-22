<?php
$conectar = mysqli_connect('localhost', 'root', '', 'finotrato');

if (!$conectar) {
    die("Falha na conexão: " . mysqli_connect_error());
}

$search = '';
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conectar, $_POST['search']);
}

ob_start();
?>

<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Cadastro</title>
    <link rel="stylesheet" type="text/css" href="style/style.css">
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

        .form-container {
            background-color: white;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 425px;
        }

        h2 {
            text-align: left;
            margin-bottom: 20px;
            font-weight: normal;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: transparent;
            font-size: 16px;
            color: #333;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
        }

        .form-group input::placeholder,
        .form-group select::placeholder {
            color: #999;
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            background-color: white;
            padding: 0 5px;
            font-size: 16px;
            color: #999;
            pointer-events: none;
            transition: 0.2s ease all;
        }

        .form-group input:focus+label,
        .form-group input:not(:placeholder-shown)+label,
        .form-group select:focus+label,
        .form-group select:not([value=""])+label {
            top: -0.5px;
            left: 10px;
            font-size: 12px;
        }

        .form-group input.valid,
        .form-group select.valid {
            border-color: #28a745 !important;
        }

        .form-group input.invalid,
        .form-group select.invalid {
            border-color: #dc3545 !important;
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #e47e40;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }

        .btn-submit:hover {
            background-color: #c46429;
        }

        .terms-group {
            display: flex;
            align-items: center;
            margin-top: -10px;
            font-size: 14px;
        }

        .terms-group input[type="checkbox"] {
            margin-right: 10px;
        }

        .terms-group label {
            margin: 0;
            color: #333;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .form-half {
            flex: 1;
            min-width: 0;
        }

        .form-third {
            flex: 1;
            min-width: 0;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            outline: none;
        }

        .password-toggle img {
            width: 20px;
            height: 20px;
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
                <div class="topSearch">
                    <input type="text" id="topSearch" placeholder="Pesquisar">
                </div>
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
    </div>
    <div class="middle">
        <div class="form-container">
            <h2>Preencha os campos com suas informações.</h2>
            <form id="formCadastro" action="cadastro.php" method="POST">
                <!-- Nome -->
                <div class="form-group">
                    <input type="text" id="nome" name="nome" placeholder=" " required>
                    <label for="nome">Nome</label>
                </div>

                <!-- CPF e Telefone lado a lado -->
                <div class="form-row">
                    <div class="form-group form-half">
                        <input type="text" id="cpf" name="cpf" placeholder=" " required maxlength="14">
                        <label for="cpf">CPF</label>
                    </div>
                    <div class="form-group form-half">
                        <input type="text" id="telefone" name="telefone" placeholder=" " required maxlength="15">
                        <label for="telefone">Telefone</label>
                    </div>
                </div>

                <!-- E-mail abaixo -->
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder=" " required>
                    <label for="email">E-mail</label>
                </div>

                <!-- CEP, Número de Residência e Complemento lado a lado -->
                <div class="form-row">
                    <div class="form-group form-third">
                        <input type="text" id="cep" name="cep" placeholder=" " required>
                        <label for="cep">CEP</label>
                    </div>
                    <div class="form-group form-third">
                        <input type="text" id="numero_residencia" name="numero_residencia" placeholder=" " required>
                        <label for="numero_residencia">N° Residência</label>
                    </div>
                    <div class="form-group form-third">
                        <input type="text" id="complemento" name="complemento" placeholder=" ">
                        <label for="complemento">Complemento</label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group form-half">
                        <input type="text" id="estado" name="estado" placeholder=" " required>
                        <label for="estado">Estado</label>
                    </div>
                    <div class="form-group form-half">
                        <input type="text" id="cidade" name="cidade" placeholder=" " required>
                        <label for="cidade">Cidade</label>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group form-half">
                        <input type="text" id="bairro" name="bairro" placeholder=" " required>
                        <label for="bairro">Bairro</label>
                    </div>
                    <div class="form-group form-half">
                        <input type="text" id="rua" name="rua" placeholder=" " required>
                        <label for="rua">Rua</label>
                    </div>
                </div>

                <!-- Senha e Confirmar Senha lado a lado -->
                <div class="form-row">
                    <div class="form-group form-half">
                        <input type="password" id="senha" name="senha" placeholder=" " required>
                        <label for="senha">Senha</label>
                        <button type="button" class="password-toggle" id="togglePassword" aria-label="Mostrar Senha">
                            <img src="img/show-password.png" alt="Mostrar Senha" id="passwordIcon">
                        </button>
                    </div>
                    <div class="form-group form-half">
                        <input type="password" id="confirmar_senha" name="confirmar_senha" placeholder=" " required>
                        <label for="confirmar_senha">Confirmar Senha</label>
                        <button type="button" class="password-toggle" id="toggleConfirmPassword"
                            aria-label="Mostrar Senha">
                            <img src="img/show-password.png" alt="Mostrar Senha" id="confirmPasswordIcon">
                        </button>
                    </div>
                </div>

                <!-- Termos de Serviço -->
                <div class="terms-group">
                    <input type="checkbox" id="termos" name="termos" required>
                    <label for="termos">Aceito os Termos de Serviço</label>
                </div>
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $nome = $_POST['nome'];
                    $cpf = $_POST['cpf'];
                    $telefone = $_POST['telefone'];
                    $email = $_POST['email'];
                    $cep = $_POST['cep'];
                    $numero_residencia = $_POST['numero_residencia'];
                    $email = $_POST['email'];
                    $complemento = $_POST['complemento'];
                    $estado = $_POST['estado'];
                    $cidade = $_POST['cidade'];
                    $bairro = $_POST['bairro'];
                    $rua = $_POST['rua'];
                    $senha = md5($_POST['senha']);

                    $endereco = "$rua, $numero_residencia - $bairro, $cidade - $estado, $cep";
                    if (!empty($complemento)) {
                        $endereco .= ", ($complemento)";
                    }

                    $sql = "INSERT INTO usuario (nome, email, cpf, telefone, endereco, senha, imagem, status) VALUES ('$nome', '$email', '$cpf', '$telefone', '$endereco', '$senha', 'NULL', 'Usuário')";
                    $resultado = mysqli_query($conectar, $sql);

                    if ($resultado) {
                        // Exibe a mensagem e redireciona
                        echo("Cadastro realizado com sucesso!");
                        header("Location: login.php");
                        exit(); // Finaliza o script após redirecionamento
                    } else {
                        echo "Erro ao cadastrar: " . mysqli_error($conectar);
                    }  
                }
                ?>

                <button type="submit" class="btn-submit">Cadastrar</button>
            </form>
        </div>
    </div>

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

    <script>
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

        function formatarCEP(cep) {
            return cep
                .replace(/\D/g, '') // Remove caracteres não numéricos
                .replace(/^(\d{5})(\d)/, '$1-$2') // Adiciona o hífen após os cinco primeiros dígitos
                .replace(/(-\d{3})\d+$/, '$1'); // Limita a 8 dígitos
        }

        function validarCampo(campo, regex) {
            if (regex.test(campo.value)) {
                campo.classList.remove('invalid');
                campo.classList.add('valid');
                campo.style.borderColor = '#28a745';
            } else {
                campo.classList.remove('valid');
                campo.classList.add('invalid');
                campo.style.borderColor = '#dc3545';
            }
        }

        // Formatação e validação dos campos
        document.getElementById('cpf').addEventListener('input', function () {
            this.value = formatarCPF(this.value);
            validarCampo(this, /^\d{3}\.\d{3}\.\d{3}-\d{2}$/); // Validação CPF formatado
        });

        document.getElementById('telefone').addEventListener('input', function () {
            this.value = formatarTelefone(this.value);
            validarCampo(this, /^\(\d{2}\) \d{5}-\d{4}$/); // Validação Telefone formatado
        });

        document.getElementById('cep').addEventListener('input', function () {
            this.value = formatarCEP(this.value);
            validarCampo(this, /^\d{5}-\d{3}$/); // Validação CEP formatado
        });

        document.getElementById('numero_residencia').addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, ''); // Remove qualquer caractere que não seja número
            validarCampo(this, /^\d+$/); // Validação para aceitar apenas números
        });


        document.getElementById('nome').addEventListener('blur', function () {
            validarCampo(this, /^[a-zA-ZÀ-ÿ\s]+$/); // Nome com letras, acentos e espaços
        });


        document.getElementById('email').addEventListener('blur', function () {
            validarCampo(this, /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/); // Validação de e-mail
        });

        document.getElementById('senha').addEventListener('blur', function () {
            validarCampo(this, /^.{6,}$/); // Senha com no mínimo 6 caracteres
        });

        document.getElementById('confirmar_senha').addEventListener('blur', function () {
            var senha = document.getElementById('senha').value;
            if (this.value === senha) {
                this.classList.remove('invalid');
                this.classList.add('valid');
                this.style.borderColor = '#28a745'; // Verde
            } else {
                this.classList.remove('valid');
                this.classList.add('invalid');
                this.style.borderColor = '#dc3545'; // Vermelho
            }
        });

        // Impede o envio se houver campos inválidos
        document.getElementById('formCadastro').addEventListener('submit', function (event) {
            var camposInvalidos = document.querySelectorAll('.invalid');
            if (camposInvalidos.length > 0) {
                alert('Por favor, corrija os campos marcados em vermelho antes de continuar.');
                event.preventDefault();
            }

            var senha = document.getElementById('senha').value;
            var confirmarSenha = document.getElementById('confirmar_senha').value;

            if (senha !== confirmarSenha) {
                alert('As senhas não coincidem!');
                event.preventDefault();
            }
        });

        // Função para alternar a visibilidade da senha
        function togglePasswordVisibility(fieldId, iconId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);

            if (field.type === 'password') {
                field.type = 'text';
                icon.src = 'img/hide-password.png'
            } else {
                field.type = 'password';
                icon.src = 'img/show-password.png';
            }
        }

        // Evento para mostrar/ocultar a senha
        document.getElementById('togglePassword').addEventListener('click', function () {
            togglePasswordVisibility('senha', 'passwordIcon');
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            togglePasswordVisibility('confirmar_senha', 'confirmPasswordIcon');
        });

        function consultarCEP() {
            var cep = document.getElementById('cep').value.replace(/\D/g, '');

            if (cep.length === 8) {
                var url = `https://viacep.com.br/ws/${cep}/json/`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('estado').value = data.uf;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('rua').value = data.logradouro;
                        } else {
                            alert("CEP não encontrado.");
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao consultar o CEP:', error);
                        alert("Não foi possível consultar o CEP.");
                    });
            }
        }

        document.getElementById('cep').addEventListener('blur', function () {
            this.value = formatarCEP(this.value);
            consultarCEP();
        });
    </script>

</body>

</html>