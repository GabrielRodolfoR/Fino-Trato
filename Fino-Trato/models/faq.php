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

        .faq-section {
            margin-bottom: 20px;
        }

        .faq-section h2 {
            color: #444;
            margin-bottom: 10px;
        }

        .faq-section p {
            margin: 0;
            padding: 0 0 10px 0;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <title>FAQ Fino Trato</title>
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
                <a href="home.php">Início</a>
                <a href="corte.php">Corte</a>
                <a href="churrasco.php">Churrasco</a>
                <a href="frios.php">Frios</a>
                <a href="personalizar.php">Personalizar</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row g-3">
            <h1>FAQ - Perguntas Frequentes</h1>
            <p>Bem-vindo à seção de perguntas frequentes do <strong>Fino Trato</strong>. Aqui você encontra respostas para as dúvidas mais comuns. Caso sua dúvida não esteja listada, entre em contato conosco!</p>

            <div class="faq-section">
                <h2>1. O que é o Fino Trato?</h2>
                <p>O <strong>Fino Trato</strong> é uma loja virtual especializada na venda de tábuas de madeira personalizadas e prontas. Nosso objetivo é oferecer produtos de alta qualidade e permitir que você crie tábuas exclusivas de acordo com suas necessidades e preferências.</p>
            </div>

            <div class="faq-section">
                <h2>2. Posso criar minha própria tábua?</h2>
                <p>Sim! Em nossa plataforma, você pode personalizar tábuas escolhendo o tipo de madeira, as dimensões e o design. Basta acessar a opção "Personalizar" no menu principal e seguir as instruções.</p>
            </div>

            <div class="faq-section">
                <h2>3. Como acompanho o status do meu pedido?</h2>
                <p>Após finalizar sua compra, você pode acompanhar o processo de produção e entrega diretamente em sua conta, na seção "Meus Pedidos". Lá você encontrará atualizações em tempo real sobre o status do seu pedido.</p>
            </div>

            <div class="faq-section">
                <h2>4. Quais são os tipos de tábuas disponíveis?</h2>
                <p>Oferecemos três categorias principais:</p>
                <ul>
                    <li><strong>Corte:</strong> Tábuas robustas e resistentes, ideais para uso na cozinha.</li>
                    <li><strong>Churrasco:</strong> Modelos com suporte para carnes e acessórios de churrasco.</li>
                    <li><strong>Frios:</strong> Tábuas elegantes, perfeitas para servir queijos e embutidos.</li>
                </ul>
            </div>
            <h2>5. Quais métodos de pagamento são aceitos?</h2>
            <p>Aceitamos cartões de crédito, débito e pagamentos via Pix. As opções disponíveis aparecerão na etapa de finalização da compra.</p>


            <div class="faq-section">
                <h2>6. Posso alterar o endereço de entrega após realizar o pedido?</h2>
                <p>Sim, desde que o pedido ainda esteja em produção. Para alterar o endereço, acesse "Meus Pedidos", selecione o pedido desejado e edite as informações de entrega.</p>
            </div>

            <div class="faq-section">
                <h2>7. Como faço para entrar em contato com o suporte?</h2>
                <p>Se você tiver dúvidas ou precisar de ajuda, entre em contato conosco através da seção "Fale Conosco" no site ou envie um e-mail para suporte@finotrato.com.br.</p>
            </div>

            <div class="faq-section">
                <h2>8. Vocês oferecem garantia nos produtos?</h2>
                <p>Sim. Nossas tábuas possuem garantia contra defeitos de fabricação por um período de 90 dias. Caso identifique algum problema, entre em contato com nosso suporte.</p>
            </div>

            <div class="faq-section">
                <h2>9. Há um pedido mínimo para compras personalizadas?</h2>
                <p>Não. Você pode personalizar e comprar apenas uma tábua, se desejar.</p>
            </div>

            <div class="faq-section">
                <h2>10. Como funciona o cálculo do frete?</h2>
                <p>O frete é calculado automaticamente com base no endereço de entrega e no peso total do pedido. Você verá o valor final do frete antes de concluir sua compra.</p>
            </div>
        </div>
    </div>
    <br><br>
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
                    <a href="https://www.facebook.com/giovane.rabello.77?_rdr"><img src="img/facebook_icon.png" alt="Facebook"></a>
                    <a href="#"><img src="img/whatsapp_icon.png" alt="Whatsapp"></a>
                    <a href="#"><img src="img/instagram_icon.png" alt="Instagram"></a>
                </div>
            </div>
        </div>

        <div class="copyright">
            &copy; 2024 Finotrato. Todos os direitos reservados.
        </div>
    </footer>
</body>

</html>