-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 22-Nov-2024 às 20:22
-- Versão do servidor: 5.7.17
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `finotrato`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrega`
--

CREATE TABLE `entrega` (
  `codigo` int(5) NOT NULL,
  `codUsuario` int(5) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `produto` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `entrega`
--

INSERT INTO `entrega` (`codigo`, `codUsuario`, `cpf`, `endereco`, `produto`, `status`) VALUES
(3, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'tabua de churrasco', 'Pendente'),
(6, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Corte', 'Pendente'),
(7, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Corte', 'Pendente'),
(8, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Corte', 'Pendente'),
(9, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Medidas: 30 cm x 40 cm x 2,5 cm.', 'Aprovado'),
(10, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Medidas: 30 cm x 40 cm x 2,5 cm.', 'Aprovado'),
(11, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Medidas: 30cm x 45cm x 2,5cm.', 'Aprovado'),
(12, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Medidas: 30cm x 45cm x 2,5cm.', 'Aprovado'),
(13, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Medidas: 30cm x 45cm x 2,5cm.', 'Aprovado'),
(14, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Medidas: 30cm x 45cm x 2,5cm.', 'Aprovado'),
(15, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de  (Medidas: 30cm x 45cm x 2,5cm.)', 'Aprovado'),
(16, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de  (Medidas: 30cm x 45cm x 2,5cm.)', 'Aprovado'),
(17, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.)', 'Aprovado'),
(18, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 2', 'Aprovado'),
(19, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 40cm x 60cm x 3cm.) - Quantidade: 1', 'Aprovado'),
(20, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 40cm x 60cm x 3cm.) - Quantidade: 1', 'Aprovado'),
(21, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 40cm x 60cm x 3cm.) - Quantidade: 1', 'Aprovado'),
(22, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 3', 'Aprovado'),
(23, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 3', 'Aprovado'),
(24, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 3', 'Aprovado'),
(25, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 3', 'Aprovado'),
(26, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30 cm x 40 cm x 2,5 cm.) - Quantidade: 1', 'Aprovado'),
(27, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30 cm x 40 cm x 2,5 cm.) - Quantidade: 1', 'Aprovado'),
(28, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30 cm x 40 cm x 2,5 cm.) - Quantidade: 1', 'Aprovado'),
(29, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 20cm x 30cm x 1,5cm.) - Quantidade: 1', 'Aprovado'),
(30, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 20cm x 30cm x 1,5cm.) - Quantidade: 1', 'Aprovado'),
(31, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 20cm x 30cm x 1,5cm.) - Quantidade: 1', 'Aprovado'),
(32, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 1', 'Aprovado'),
(33, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 1', 'Aprovado'),
(34, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 2', 'Aprovado'),
(35, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 2', 'Aprovado'),
(36, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 2', 'Aprovado'),
(37, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 2', 'Aprovado'),
(38, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 2', 'Aprovado'),
(39, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(40, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(41, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 1', 'Aprovado'),
(42, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 1', 'Aprovado'),
(43, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 1', 'Aprovado'),
(44, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 30cm x 45cm x 2,5cm.) - Quantidade: 1', 'Aprovado'),
(45, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(46, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(47, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(48, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(49, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(50, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(51, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(52, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 'Aprovado'),
(53, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 3', 'Aprovado'),
(54, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 3', 'Aprovado'),
(55, 1, '07870433977', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'Tabua de Corte (Medidas: 40cm x 60cm x 3cm.) - Quantidade: 2', 'Aprovado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `estoque`
--

CREATE TABLE `estoque` (
  `codigo` int(5) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `madeira` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `quantidade` int(5) NOT NULL,
  `preco` float(8,2) NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `estoque`
--

INSERT INTO `estoque` (`codigo`, `categoria`, `madeira`, `descricao`, `quantidade`, `preco`, `imagem`) VALUES
(1, 'Corte', 'Araucaria', 'Medidas: 20cm x 30cm x 1,5cm.', 2, 69.90, 'imageDone/66f43ef00691d.png'),
(2, 'Corte', 'Carvalho', 'Medidas: 25cm x 35cm x 2cm.', 1, 69.90, 'imageDone/66f43f02960a7.png'),
(3, 'Corte', 'Carvalho', 'Medidas: 30cm x 45cm x 2,5cm.', 2, 90.90, 'imageDone/66f43f17c3925.jpg'),
(4, 'Corte', 'Carvalho', 'Medidas: 40cm x 60cm x 3cm.', 0, 190.89, 'imageDone/66f43f2a3a94c.jpg'),
(5, 'Corte', 'Carvalho', 'Medidas: 25cm x 35cm x 2cm', 1, 87.30, 'imageDone/66f43f4650123.jpg'),
(6, 'Corte', 'Araucaria', 'Medidas: 30 cm x 40 cm x 2,5 cm.', 7, 213.89, 'imageDone/66f43f6f77640.jpg'),
(7, 'Frios', 'Araucaria', 'Medidas: 25cm x 35cm x 2cm.', 11, 50.90, 'imageDone/66f456602d026.png');

-- --------------------------------------------------------

--
-- Estrutura da tabela `financeiro`
--

CREATE TABLE `financeiro` (
  `codigo` int(5) NOT NULL,
  `codPedido` varchar(255) NOT NULL,
  `codUsuario` int(5) NOT NULL,
  `custo` float(8,2) NOT NULL,
  `precoEnd` float(8,2) NOT NULL,
  `lucro` float(8,2) NOT NULL,
  `data` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `financeiro`
--

INSERT INTO `financeiro` (`codigo`, `codPedido`, `codUsuario`, `custo`, `precoEnd`, `lucro`, `data`, `status`) VALUES
(1, '2', 2, 20.00, 60.00, 20.00, '2024-09-16', 'Em aguardo'),
(2, '2', 2, 20.00, 40.00, 0.00, '2024-10-23', 'Em aguardo'),
(3, '3', 3, 10.00, 109.90, 0.00, '2024-10-15', 'Aprovado'),
(4, '3', 3, 320.00, 410.00, 0.00, '2006-06-09', 'Aprovado'),
(5, '0', 0, 50.90, 50.90, 0.00, '2024-11-12', 'Pendente'),
(6, '0', 0, 50.90, 50.90, 0.00, '2024-11-12', 'Pendente'),
(7, '0', 1, 181.80, 181.80, 0.00, '2024-11-12', 'Pendente'),
(8, '0', 1, 69.90, 69.90, 0.00, '2024-11-12', 'Pendente'),
(9, 'Tabua de Frios (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 1', 1, 50.90, 50.90, 0.00, '2024-11-22', 'Aprovado'),
(10, 'Tabua de Corte (Medidas: 25cm x 35cm x 2cm.) - Quantidade: 3', 1, 209.70, 209.70, 0.00, '2024-11-22', 'Aprovado'),
(11, 'Tabua de Corte (Medidas: 40cm x 60cm x 3cm.) - Quantidade: 2', 1, 381.78, 381.78, 0.00, '2024-11-22', 'Aprovado');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `codigo` int(5) NOT NULL,
  `nomeUsuario` varchar(255) NOT NULL,
  `madeira` varchar(255) NOT NULL,
  `descricao` varchar(500) DEFAULT NULL,
  `imagem` varchar(255) NOT NULL,
  `comprimento` float(5,2) NOT NULL,
  `largura` float(5,2) NOT NULL,
  `espessura` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`codigo`, `nomeUsuario`, `madeira`, `descricao`, `imagem`, `comprimento`, `largura`, `espessura`) VALUES
(1, '2', 'Carvalho', 'gostaria de 20 dessas', 'imageOrder/66e73cc241216.png', 20.00, 28.00, 2.00),
(2, '1', 'Carvalho', 'Sem descriÃ§Ã£o', 'imageOrder/66e747d6c1638.png', 20.00, 28.00, 1.50),
(3, '4', 'Araucaria', 'Sem descriÃ§Ã£o', 'imageOrder/66e74d3b0c8b9.png', 10.00, 12.00, 1.20),
(4, 'Giovane Rabello', 'Madeira 2', '1', 'imageUser/6740d992bcd4a.png', 1.00, 1.00, 1.00);

-- --------------------------------------------------------

--
-- Estrutura da tabela `producao`
--

CREATE TABLE `producao` (
  `codigo` int(5) NOT NULL,
  `codPedido` int(5) NOT NULL,
  `codFinanceiro` int(5) NOT NULL,
  `dataSta` date NOT NULL,
  `dataEnd` date NOT NULL,
  `quantidade` int(5) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `producao`
--

INSERT INTO `producao` (`codigo`, `codPedido`, `codFinanceiro`, `dataSta`, `dataEnd`, `quantidade`, `descricao`, `status`) VALUES
(1, 1, 1, '2024-09-09', '2024-09-16', 2, 'Medidas: 25cm x 35cm x 2cm', 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `codigo` int(5) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(11) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`codigo`, `nome`, `email`, `cpf`, `telefone`, `endereco`, `senha`, `imagem`, `status`) VALUES
(1, 'Giovane Rabello', 'giovanerabello@gmail.com', '07870433977', '48999569805', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'e10adc3949ba59abbe56e057f20f883e', 'ImageUser/Pai.jpg', 'Administrador'),
(2, 'Gabriel Rodolfo Rabello', 'gabrielrodolforabello@gmail.com', '07870433977', '48996249687', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', '123456', 'imageUser/66f465743012d.png', 'UsuÃ¡rio'),
(3, 'Vinicius Nunes Westrup', 'viniciusnuneswestrup@gmail.com', '07870433977', '48999243807', 'Av. GÃ­lio BÃºrigo, 921 - Jardim Maristela, CriciÃºma - SC, 88815-300', 'e10adc3949ba59abbe56e057f20f883e', 'imageUser/66f4657eb86f5.png', 'UsuÃ¡rio');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codUsuario` (`codUsuario`);

--
-- Indexes for table `estoque`
--
ALTER TABLE `estoque`
  ADD PRIMARY KEY (`codigo`);

--
-- Indexes for table `financeiro`
--
ALTER TABLE `financeiro`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codPedido` (`codPedido`),
  ADD KEY `codUsuario` (`codUsuario`);

--
-- Indexes for table `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codUsuario` (`nomeUsuario`);

--
-- Indexes for table `producao`
--
ALTER TABLE `producao`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `codFinanceiro` (`codFinanceiro`),
  ADD KEY `codPedido` (`codPedido`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`codigo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entrega`
--
ALTER TABLE `entrega`
  MODIFY `codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;
--
-- AUTO_INCREMENT for table `estoque`
--
ALTER TABLE `estoque`
  MODIFY `codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `financeiro`
--
ALTER TABLE `financeiro`
  MODIFY `codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `pedido`
--
ALTER TABLE `pedido`
  MODIFY `codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `producao`
--
ALTER TABLE `producao`
  MODIFY `codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `codigo` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
