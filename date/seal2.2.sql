-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 15-Maio-2017 às 12:15
-- Versão do servidor: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `seal2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `id` int(11) NOT NULL,
  `papel_id` int(11) NOT NULL DEFAULT '2',
  `nome` varchar(45) NOT NULL,
  `username` varchar(50) NOT NULL,
  `matricula` varchar(45) NOT NULL,
  `email` varchar(60) NOT NULL,
  `ano` year(4) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `semestre` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `ativo` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `papel_id`, `nome`, `username`, `matricula`, `email`, `ano`, `senha`, `semestre`, `status`, `ativo`) VALUES
(1, 2, 'Deigon Prates Araujo', 'Deigon', '800002585', 'deigon_prates@hotmail.com', 2013, 'aa31339878fe791f30ff3e2f499e36dc', 1, 0, 0),
(2, 2, 'teste', 'teste', '12345', '000@teste.com', 2017, '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 0),
(3, 2, 'Algoritmo II', 'dsa', '123456789', 'lkklklkllk@hotmail.com', 2017, '827ccb0eea8a706c4c34a16891f84e7b', 1, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos_atividades`
--

CREATE TABLE `alunos_atividades` (
  `alunos_id` int(11) NOT NULL,
  `avaliacoes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividades`
--

CREATE TABLE `atividades` (
  `id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `tipo_id` int(11) NOT NULL DEFAULT '2',
  `conteudo` varchar(65) NOT NULL,
  `dataInicio` date NOT NULL,
  `dataTermino` date NOT NULL,
  `dataModificacao` date NOT NULL,
  `nota` float NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `atividades`
--

INSERT INTO `atividades` (`id`, `turma_id`, `tipo_id`, `conteudo`, `dataInicio`, `dataTermino`, `dataModificacao`, `nota`, `status`) VALUES
(24, 1, 2, 'do while', '2017-05-09', '2017-05-12', '2017-05-09', 0, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`id`, `descricao`) VALUES
(1, 'objetiva'),
(2, 'subjetiva');

-- --------------------------------------------------------

--
-- Estrutura da tabela `monitores`
--

CREATE TABLE `monitores` (
  `id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `papel_id` int(11) NOT NULL DEFAULT '3',
  `matricula` varchar(45) NOT NULL,
  `email` varchar(50) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `semestre` int(11) NOT NULL,
  `ano` year(4) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `username` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `monitores`
--

INSERT INTO `monitores` (`id`, `turma_id`, `papel_id`, `matricula`, `email`, `nome`, `semestre`, `ano`, `senha`, `ativo`, `status`, `username`) VALUES
(1, 1, 3, '80000123', 'teste@tete.com', 'teste', 1, 2017, '827ccb0eea8a706c4c34a16891f84e7b', 0, 1, 'teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `niveis`
--

CREATE TABLE `niveis` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `niveis`
--

INSERT INTO `niveis` (`id`, `descricao`) VALUES
(1, 'Fácil'),
(2, 'Médio '),
(3, 'Difícil ');

-- --------------------------------------------------------

--
-- Estrutura da tabela `papeis`
--

CREATE TABLE `papeis` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `papeis`
--

INSERT INTO `papeis` (`id`, `descricao`) VALUES
(1, 'professor'),
(2, 'aluno'),
(3, 'monitor');

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores`
--

CREATE TABLE `professores` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `username` varchar(50) NOT NULL,
  `papel_id` int(11) NOT NULL DEFAULT '1',
  `matricula` varchar(45) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `professores`
--

INSERT INTO `professores` (`id`, `nome`, `username`, `papel_id`, `matricula`, `senha`, `email`, `ativo`, `status`) VALUES
(1, 'Cimara Souza', 'Cimara', 1, '80000666', '827ccb0eea8a706c4c34a16891f84e7b', 'deigon_prates@hotmail.com', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `professores_turmas`
--

CREATE TABLE `professores_turmas` (
  `professor_id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `questoes`
--

CREATE TABLE `questoes` (
  `id` int(11) NOT NULL,
  `nivel_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `atividade_id` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `pergunta` blob NOT NULL,
  `alternativa_a` blob,
  `alternativa_b` blob,
  `alternativa_c` blob,
  `alternativa_d` blob,
  `alternativa_e` blob,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `questoes`
--

INSERT INTO `questoes` (`id`, `nivel_id`, `categoria_id`, `atividade_id`, `numero`, `pergunta`, `alternativa_a`, `alternativa_b`, `alternativa_c`, `alternativa_d`, `alternativa_e`, `status`) VALUES
(36, 1, 1, 32, 1, 0x6f6920, 0x736f75, 0x6f, 0x676f6b75, '', '', 1),
(37, 1, 2, 24, 1, 0x706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376706b6169c3a76a382e203b702c2e6470656f72663b706b646c6d2c706561c3b33d39696c2c6b6376, NULL, NULL, NULL, NULL, NULL, 0),
(38, 2, 1, 24, 1, 0x4f494a464c4b415344464ac3874c4153444b4a464cc387, 0x4c4b4a464c5341c3874b444a46414cc387534b4a, 0x4c4b4a464c4b4153444a464c4b4153444c46, 0x4cc3874b4a464c534b4144464c4bc38741534a, 0x4c4b4a46414c4b53444a464c414bc38753444a, 0x4c4b464a41534c444b464ac3874c41, 0),
(39, 3, 2, 24, 1, 0xefbbbf4661c3a76120756d20616c676f72c3ad74696d6f207061726120636f6e7465206465203120612032, '', '', '', '', '', 1),
(40, 2, 2, 24, 1, 0xefbbbf4661c3a76120756d20616c676f72c3ad74696d6f207061726120636f6e746520646520312061203130303030303030303030303030303030, NULL, NULL, NULL, NULL, NULL, 0),
(41, 2, 2, 24, 1, 0xefbbbf4661c3a76120756d20616c676f72c3ad74696d6f207061726120636f6e74652064652031206120363636, NULL, NULL, NULL, NULL, NULL, 0),
(42, 1, 1, 24, 1, 0x66646c6b64666b6c64666b6c, 0x6b6c6b6c, 0x6b6c, 0x6b6c, 0x6b6c, 0x6b6c, 0),
(43, 2, 1, 24, 1, 0x646c6b736c6b7364666b6c6c6b, 0x6b6c6b6c, 0x6b6c, 0x6b6c, 0x6b6c, 0x6b6c, 0),
(44, 3, 1, 24, 1, 0x6f70736f6b7067736b7e706b6f, 0x096b6f7e706b6f7e706b7e706b, 0x6b6f707e706b7e706b7e706b6f2c7e706b6f, 0x6f706b7e706b6f7e706b6f6b6f70, 0x7e706b6f7e706b6f6f6b6f706b70, 0x096f706b707e6b6f7e706b6b, 0),
(45, 3, 1, 24, 1, 0x6f70736f6b7067736b7e706b6f, 0x096b6f7e706b6f7e706b7e706b, 0x6b6f707e706b7e706b7e706b6f2c7e706b6f, 0x6f706b7e706b6f7e706b6f6b6f70, 0x7e706b6f7e706b6f6f6b6f706b70, 0x096f706b707e6b6f7e706b6b, 0),
(46, 3, 1, 24, 1, 0x6f70736f6b7067736b7e706b6f, 0x096b6f7e706b6f7e706b7e706b, 0x6b6f707e706b7e706b7e706b6f2c7e706b6f, 0x6f706b7e706b6f7e706b6f6b6f70, 0x7e706b6f7e706b6f6f6b6f706b70, 0x096f706b707e6b6f7e706b6b, 0),
(47, 2, 1, 24, 1, 0x6166646c6d6166646c6b6d, 0x6c6b6d6c6b, 0x6d, 0x6c6b6d, 0x6c6b, 0x6d6c6b, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `alunos_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `questoes_id` int(11) NOT NULL,
  `resposta` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `solucoes`
--

CREATE TABLE `solucoes` (
  `id` int(11) NOT NULL,
  `questoes_id` int(11) NOT NULL,
  `solucao` blob,
  `alternativa` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `solucoes`
--

INSERT INTO `solucoes` (`id`, `questoes_id`, `solucao`, `alternativa`) VALUES
(1, 11, '', 'e'),
(2, 12, 0x6c6b7364666a6c666b73616a646c666a616c736b646a666c61736b646a66, ''),
(3, 13, '', 'e'),
(4, 14, 0x6f6975687976676862796e6a756f6b702c69687562796b677668626a6e6b696d, ''),
(5, 15, 0xc3a769c3a7696f6a6f7e6a6d, ''),
(6, 16, 0x70756968c2b47075686e70, ''),
(7, 17, 0x7e706a7e706a6f7e706a7e6a, ''),
(8, 18, 0x6c666a6173c3a76c64666a617ec3a773646a66c3a3c3a764, ''),
(9, 19, 0x6cc3a7666b6173c3a76c64666b61737ec3a764666b617ec3a77364, ''),
(10, 20, 0x6cc3a7666b6173c3a77e646b66617e73c3a7646b66617e73c3a764666b, ''),
(11, 21, 0x6c6b7e6c6b7ec3a7, ''),
(12, 22, 0x6f6e6f6e6f6e6f6e6f6e, ''),
(13, 23, 0x09c3b3666a61c2b4736f646a66c3a173646f6a66c3a1, ''),
(14, 24, 0x696f68666f6964736168666f69c3a7617364, ''),
(15, 25, '', '6'),
(16, 26, 0x666f7228297b7d, ''),
(17, 27, 0x6f6b, ''),
(18, 31, '', 'c'),
(19, 32, 0xc3a3736b6466c3a7616b73c3a7646b666173c3a77e64666bc3a7616c73646b66c3a7c3a3646b73667ec3a761736b64667ec3a76173646b, ''),
(20, 33, '', 'a'),
(21, 34, '', ''),
(22, 35, '', ''),
(23, 36, '', ''),
(24, 37, 0x6c6b6a6c6b6a, ''),
(25, 38, '', ''),
(26, 39, 0x756d2c20646f6973, ''),
(27, 40, 0x64662c6466732c6d, ''),
(28, 41, 0x64662c6466732c6d, ''),
(29, 42, '', ''),
(30, 43, '', ''),
(31, 44, '', ''),
(32, 45, '', ''),
(33, 46, '', ''),
(34, 47, '', 'a');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tentativas_login`
--

CREATE TABLE `tentativas_login` (
  `id` int(11) NOT NULL,
  `data` date NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `papel_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tentativas_login`
--

INSERT INTO `tentativas_login` (`id`, `data`, `usuario_id`, `papel_id`) VALUES
(15, '2017-05-05', 1, 2),
(16, '2017-05-17', 3, 1),
(17, '2017-05-06', 1, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipos`
--

CREATE TABLE `tipos` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipos`
--

INSERT INTO `tipos` (`id`, `descricao`) VALUES
(1, 'atividade avaliativa '),
(2, 'atividade para estudos');

-- --------------------------------------------------------

--
-- Estrutura da tabela `turmas`
--

CREATE TABLE `turmas` (
  `id` int(11) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `professor` varchar(50) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `ano` year(4) NOT NULL,
  `semestre` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `turmas`
--

INSERT INTO `turmas` (`id`, `codigo`, `professor`, `nome`, `ano`, `semestre`, `status`) VALUES
(1, 'algo66f6ds', 'Cimara Souza', 'algoritmo I', 2017, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `matricula_UNIQUE` (`matricula`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_aluno_papel1_idx` (`papel_id`);

--
-- Indexes for table `alunos_atividades`
--
ALTER TABLE `alunos_atividades`
  ADD KEY `fk_alunos_has_avaliacoes_avaliacoes1_idx` (`avaliacoes_id`),
  ADD KEY `fk_alunos_has_avaliacoes_alunos_idx` (`alunos_id`);

--
-- Indexes for table `atividades`
--
ALTER TABLE `atividades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_avaliacoes_turma1_idx` (`turma_id`),
  ADD KEY `fk_avaliacoes_tipo1_idx` (`tipo_id`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monitores`
--
ALTER TABLE `monitores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `maticula_UNIQUE` (`matricula`),
  ADD KEY `fk_monitor_turma1_idx` (`turma_id`),
  ADD KEY `fk_monitor_papel1_idx` (`papel_id`);

--
-- Indexes for table `niveis`
--
ALTER TABLE `niveis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `papeis`
--
ALTER TABLE `papeis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `professores`
--
ALTER TABLE `professores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificacao_UNIQUE` (`matricula`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_professor_papel1_idx` (`papel_id`);

--
-- Indexes for table `professores_turmas`
--
ALTER TABLE `professores_turmas`
  ADD KEY `fk_professor_has_turma_turma1_idx` (`turma_id`),
  ADD KEY `fk_professor_has_turma_professor1_idx` (`professor_id`);

--
-- Indexes for table `questoes`
--
ALTER TABLE `questoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_questoes_nivel1_idx` (`nivel_id`),
  ADD KEY `fk_questoes_atividade1_idx` (`atividade_id`),
  ADD KEY `fk_questoes_categoria1_idx` (`categoria_id`);

--
-- Indexes for table `registros`
--
ALTER TABLE `registros`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_matricula_turma1_idx` (`turma_id`),
  ADD KEY `fk_matricula_alunos1_idx` (`alunos_id`);

--
-- Indexes for table `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_respostas_questoes1_idx` (`questoes_id`);

--
-- Indexes for table `solucoes`
--
ALTER TABLE `solucoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_gabaritos_questoes1_idx` (`questoes_id`);

--
-- Indexes for table `tentativas_login`
--
ALTER TABLE `tentativas_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos`
--
ALTER TABLE `tipos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `turmas`
--
ALTER TABLE `turmas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `alunos_atividades`
--
ALTER TABLE `alunos_atividades`
  MODIFY `alunos_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `monitores`
--
ALTER TABLE `monitores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `niveis`
--
ALTER TABLE `niveis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `papeis`
--
ALTER TABLE `papeis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `professores`
--
ALTER TABLE `professores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `professores_turmas`
--
ALTER TABLE `professores_turmas`
  MODIFY `professor_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `questoes`
--
ALTER TABLE `questoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `registros`
--
ALTER TABLE `registros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `respostas`
--
ALTER TABLE `respostas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `solucoes`
--
ALTER TABLE `solucoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `tentativas_login`
--
ALTER TABLE `tentativas_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tipos`
--
ALTER TABLE `tipos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `turmas`
--
ALTER TABLE `turmas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `fk_aluno_papel1` FOREIGN KEY (`papel_id`) REFERENCES `papeis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `alunos_atividades`
--
ALTER TABLE `alunos_atividades`
  ADD CONSTRAINT `fk_alunos_has_avaliacoes_alunos` FOREIGN KEY (`alunos_id`) REFERENCES `alunos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_alunos_has_avaliacoes_avaliacoes1` FOREIGN KEY (`avaliacoes_id`) REFERENCES `atividades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `atividades`
--
ALTER TABLE `atividades`
  ADD CONSTRAINT `fk_avaliacoes_tipo1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_avaliacoes_turma1` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `monitores`
--
ALTER TABLE `monitores`
  ADD CONSTRAINT `fk_monitor_papel1` FOREIGN KEY (`papel_id`) REFERENCES `papeis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_monitor_turma1` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `professores`
--
ALTER TABLE `professores`
  ADD CONSTRAINT `fk_professor_papel1` FOREIGN KEY (`papel_id`) REFERENCES `papeis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `professores_turmas`
--
ALTER TABLE `professores_turmas`
  ADD CONSTRAINT `fk_professor_has_turma_professor1` FOREIGN KEY (`professor_id`) REFERENCES `professores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_professor_has_turma_turma1` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `questoes`
--
ALTER TABLE `questoes`
  ADD CONSTRAINT `fk_questoes_atividade1` FOREIGN KEY (`atividade_id`) REFERENCES `atividades` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_questoes_categoria1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_questoes_nivel1` FOREIGN KEY (`nivel_id`) REFERENCES `niveis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `registros`
--
ALTER TABLE `registros`
  ADD CONSTRAINT `fk_matricula_alunos1` FOREIGN KEY (`alunos_id`) REFERENCES `alunos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_matricula_turma1` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `fk_respostas_questoes1` FOREIGN KEY (`questoes_id`) REFERENCES `questoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `solucoes`
--
ALTER TABLE `solucoes`
  ADD CONSTRAINT `fk_gabaritos_questoes1` FOREIGN KEY (`questoes_id`) REFERENCES `questoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
