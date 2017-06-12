-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Jun-2017 às 03:39
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
  `salt` varchar(255) NOT NULL,
  `semestre` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `ativo` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id`, `papel_id`, `nome`, `username`, `matricula`, `email`, `ano`, `senha`, `salt`, `semestre`, `status`, `ativo`) VALUES
(1, 2, 'Deigon Prates Araujo', 'deigon', '800002585', 'deigon_prates@hotmail.com', 2017, 'b7f79108aaa63319227142758d40e13ec378c48b78a3da36aa7f13b9ba057caadcbcbf2a4b75fee5003b6c9a1da875b314c43c38ae4389b450dd0320d6a573f4', 'c7e69368c1623a75071ed85771d2c8c0751c212de140c9c681e299fd156d5418c530a8defd40a872e44d383a26f21bacd9a3a30bb03808f13b89698a35621ea3', 1, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos_atividades`
--

CREATE TABLE `alunos_atividades` (
  `id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL,
  `avaliacao_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
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
-- Estrutura da tabela `exemplos`
--

CREATE TABLE `exemplos` (
  `id` int(11) NOT NULL,
  `niveis_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `conteudo` varchar(65) NOT NULL,
  `pergunta` blob NOT NULL,
  `alternativa_a` blob,
  `alternativa_b` blob,
  `alternativa_c` blob,
  `alternativa_d` blob,
  `alternativa_e` blob,
  `alternativa` char(1) DEFAULT NULL,
  `solucao` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `exemplos`
--

INSERT INTO `exemplos` (`id`, `niveis_id`, `categoria_id`, `conteudo`, `pergunta`, `alternativa_a`, `alternativa_b`, `alternativa_c`, `alternativa_d`, `alternativa_e`, `alternativa`, `solucao`) VALUES
(1, 1, 2, 'logica', 0x4661c3a76120756d20616c676f7269746d6f20706172612063616c63756c6172206120c3a172656120646520756d612063697263756e666572c3aa6e6369612c20636f6e7369646572616e646f206166c3b3726d756c6120c381524541203d2070202a205241494f322e200d0a5574696c697a652061732076617269c3a17665697320415245412065205241494f2c206120636f6e7374616e7465207020287069203d332c3134313539292065206f206f70657261646f7220617269746dc3a97469636f73206465206d756c7469706c696361c3a7c3a36f2e, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c756465203c737464696f2e683e0d0a23696e636c756465203c7374646c69622e683e0d0a09696e74206d61696e28297b090d0a09090d0a0909666c6f6174207261696f203d20303b090d0a0909666c6f61742061726561203d20303b200d0a0909666c6f6174207069203d20332e31343135393b200d0a09090d0a09097072696e74662827496e666f726d65206f207261696f3a5c6e27293b0d0a09097363616e6628272566272c20267261696f293b200d0a090961726561203d207069202a20287261696f202a207261696f293b200d0a09097072696e7466282741206172656120746f74616c20653a2566272c2061726561293b200d0a09090d0a090972657475726e20303b0d0a097d22),
(2, 1, 2, '', 0x4c657220756d206ec3ba6d65726f20696e746569726f206520696d7072696d697220736575207375636573736f7220652073657520616e7465636573736f722e20, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c7564653c737464696f2e683e0d0a23696e636c7564653c7374646c69622e683e0d0a23696e636c7564653c636f6e696f2e683e0d0a23696e636c7564653c6d6174682e683e0d0a23696e636c7564653c737472696e672e683e0d0a6d61696e28290d0a7b0d0a696e7420782c206e312c206e323b0d0a7072696e746628225c6e5c6e2044696769746520756d206e756d65726f3a2022293b200d0a7363616e6628222564222c2678293b0d0a6e313d782b313b0d0a6e323d782d313b0d0a7072696e746628225c6e5c6e536575207375636573736f722065203a202564222c6e31293b0d0a7072696e746628225c6e5c6e53657520616e7465636573736f722065203a202564222c6e32293b0d0a7072696e746628225c6e5c6e22293b0d0a73797374656d2822706175736522293b0d0a72657475726e202830293b0d0a7d20),
(3, 1, 2, 'Porcentagem', 0x5265636562657220756d2076616c6f72207175616c7175657220646f207465636c61646f206520696d7072696d697220657373652076616c6f7220636f6d207265616a75737465206465203130252e2e200d0a, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c7564653c737464696f2e683e0d0a23696e636c7564653c7374646c69622e683e0d0a23696e636c7564653c636f6e696f2e683e0d0a23696e636c7564653c6d6174682e683e0d0a23696e636c7564653c737472696e672e683e0d0a6d61696e28290d0a7b0d0a666c6f61742076613b0d0a7072696e746628225c6e5c7444696769746520756d206e756d65726f3a2022293b0d0a7363616e6628222566222c267661293b0d0a7072696e746628225c6e5c7456616c6f72207265616a75737461646f20656d203130252520653a2025322e32665c6e222c76612a3131302f313030293b0d0a7072696e746628225c6e5c6e22293b0d0a73797374656d2822706175736522293b0d0a72657475726e20303b0d0a7d20),
(4, 1, 2, 'media', 0x496e666f726d61722074726573206e756d65726f7320696e746569726f73206520696d7072696d69722061206dc3a964696120, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c756465203c737464696f2e683e0d0a23696e636c756465203c7374646c69622e683e0d0a23696e636c756465203c636f6e696f2e683e0d0a23696e636c756465203c6d6174682e683e0d0a696e74206d61696e28290d0a7b0d0a20696e7420612c622c633b0d0a207072696e74662822496e666f726d6520756d206e756d65726f20696e746569726f3a2022293b0d0a207363616e6628222564222c2661293b0d0a207072696e74662822496e666f726d6520756d206e756d65726f20696e746569726f3a2022293b0d0a207363616e6628222564222c2662293b0d0a207072696e74662822496e666f726d6520756d206e756d65726f20696e746569726f3a2022293b0d0a207363616e6628222564222c2663293b0d0a207072696e7466282241206d6564696120646f732074726573206e756d65726f7320696e666f726d61646f7320653a2025342e32665c6e5c6e222c666c6f61742828612b622b6329292f33293b0d0a2073797374656d2822504155534522293b0d0a2072657475726e20303b0d0a7d200d0a),
(5, 2, 2, 'media', 0x496e666f726d65206f2074656d706f20676173746f206e756d612076696167656d2028656d20686f726173292c20612076656c6f636964616465206dc3a964696120652063616c63756c65206f20636f6e73756d6f2e20, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c756465203c737464696f2e683e0d0a23696e636c756465203c636f6e696f2e683e0d0a23696e636c756465203c6d6174682e683e0d0a23696e636c756465203c7374646c69622e683e0d0a6d61696e28290d0a7b0d0a20696e7420686f7261732c2076656c6d656469613b0d0a20666c6f61742064697374616e6369612c20636f6e73756d6f3b0d0a207072696e74662822496e666f726d65206f2074656d706f20676173746f206e612076696167656d20656d20686f7261733a2022293b0d0a207363616e6628222564222c2026686f726173293b0d0a207072696e74662822496e666f726d6520612076656c6f636964616465206dc3a964696120646f207665c3ad63756c6f3a2022293b0d0a207363616e6628222564222c202676656c6d65646961293b0d0a2064697374616e636961203d20686f726173202a2076656c6d656469613b0d0a20636f6e73756d6f203d2064697374616e636961202f2031323b200d0a20207072696e74662822466f72616d20676173746f732025342e326620646520636f6d627573746976656c222c636f6e73756d6f293b0d0a2073797374656d2822706175736522293b0d0a2072657475726e20303b0d0a7d200d0a),
(6, 1, 2, 'logica quadrado de um numero', 0x4c657220756d206ec3ba6d65726f20696e746569726f206520696d7072696d69722073657520717561647261646f2e20, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c756465203c737464696f2e683e0d0a23696e636c756465203c7374646c69622e683e0d0a23696e636c756465203c636f6e696f2e683e0d0a23696e636c756465203c6d6174682e683e0d0a696e74206d61696e28290d0a7b0d0a20666c6f617420613b0d0a207072696e74662822496e666f726d6520756d206e756d65726f20696e746569726f3a2022293b0d0a207363616e6628222566222c2661293b0d0a207072696e746628224f20717561647261646f20646f206e756d65726f20696e666f726d61646f20653a2025332e30665c6e5c6e222c706f7728612c3229293b0d0a202f2f20706172612075736172206120706f74656e6369612c207573612d736520706f77286e756d65726f2c20706f74656e636961290d0a2073797374656d2822504155534522293b0d0a2072657475726e20303b0d0a7d200d0a),
(7, 1, 2, 'logica simples porcentagem', 0x496e666f726d617220756d2073616c646f206520696d7072696d6972206f2073616c646f20636f6d207265616a757374652064652031250d0a, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c756465203c737464696f2e683e0d0a23696e636c756465203c7374646c69622e683e0d0a23696e636c756465203c636f6e696f2e683e0d0a23696e636c756465203c6d6174682e683e0d0a696e74206d61696e28290d0a7b0d0a20666c6f61742073616c646f3b0d0a207072696e74662822496e666f726d65206f2076616c6f7220646f2073616c646f3a2022293b0d0a207363616e6628222566222c2673616c646f293b0d0a207072696e746628224f2073616c646f20636f7272696769646f20652025342e32665c6e5c6e222c73616c646f202a20312e3031293b0d0a2073797374656d2822504155534522293b0d0a2072657475726e20303b0d0a7d200d0a),
(8, 3, 2, 'logica media ', 0x43616c63756c65206520696d7072696d61206f2076616c6f7220656d2072656169732064652063616461206b77206f2076616c6f7220656d207265616973206120736572207061676f206f206e6f766f2076616c6f722061207365720d0a7061676f20706f722065737361207265736964656e63696120636f6d20756d20646573636f6e746f206465203130252e204461646f3a20313030206b696c6f776174747320637573746120312f3720646f2073616c6172696f0d0a6d696e696d6f2e207175616e746964616465206465206b7720676173746f20706f72207265736964656e636961, NULL, NULL, NULL, NULL, NULL, NULL, 0x23696e636c756465203c737464696f2e683e0d0a23696e636c756465203c7374646c69622e683e0d0a23696e636c756465203c636f6e696f2e683e0d0a23696e636c756465203c6d6174682e683e0d0a696e74206d61696e28290d0a7b0d0a20666c6f617420534d2c206b77676173746f2c20756d6b773b0d0a207072696e74662822496e666f726d65206f2076616c6f7220646f2073616c6172696f206d696e696d6f3a2022293b0d0a207363616e6628222566222c26534d293b0d0a207072696e746628225c6e5c6e496e666f726d6520746f74616c204b7720676173746f206e61207265736964656e6369613a2022293b0d0a207363616e6628222566222c266b77676173746f293b0d0a20756d6b77203d20534d2f372f3130303b0d0a207072696e746628225c6e5c6e4f2076616c6f722064652031204b7720653a2025332e32665c6e5c6e222c756d6b77293b0d0a207072696e746628225c6e4f2076616c6f72206120736572207061676f2070656c61207265736964656e63696120653a2025342e3266222c6b77676173746f202a20756d6b77293b0d0a207072696e746628225c6e5c6e4e6f766f2076616c6f72206120736572207061676f20636f6d20646573636f6e746f206465203130252520653a2025332e32665c6e5c6e222c286b77676173746f202a20756d6b7729202a20302e3930293b0d0a2073797374656d2822504155534522293b0d0a2072657475726e20303b0d0a7d200d0a),
(9, 3, 2, 'equação do 2 grau', 0x446573656e766f6c76657220756d20616c676f7269746d6f20717565206c656961206f7320636f6566696369656e746573202861202c2062206520632920646520756d612065717561c3a7c3a36f20646f20736567756e646f206772617520652063616c63756c652073756173207261c3ad7a65732e204f2070726f6772616d612064657665206d6f73747261722c207175616e646f20706f7373c3ad76656c2c206f2076616c6f7220646173207261c3ad7a65732063616c63756c616461732065206120636c6173736966696361c3a7c3a36f20646173207261c3ad7a65732e, NULL, NULL, NULL, NULL, NULL, NULL, 0x2f2a23696e636c7564653c737464696f2e683e0d0a23696e636c7564653c6d6174682e683e0d0a0d0a696e74206d61696e28290d0a7b0d0a666c6f617420612c20622c20632c2064656c74612c2058312c2058323b0d0a0d0a7363616e6628222566222c2661293b0d0a7363616e6628222566222c2662293b0d0a7363616e6628222566222c2663293b0d0a0d0a64656c7461203d2028706f7728622c3229202d2034202a2061202a2063293b0d0a5831203d20282d62202b20737172742864656c746129292f2832202a2061293b0d0a5832203d20282d62202d20737172742864656c746129292f202832202a2061293b0d0a0d0a6966202864656c7461203d3d2030290d0a7b0d0a7072696e746628225241495a20554e4943415c6e22293b0d0a7072696e746628225831203d20252e32665c6e222c5831293b0d0a7d0d0a0d0a656c7365206966202864656c7461203c203020290d0a7b0d0a7072696e746628225241495a455320494d4147494e41524941535c6e22293b0d0a7d0d0a0d0a656c7365206966202864656c7461203e203020290d0a7b0d0a7072696e746628225241495a45532044495354494e5441535c6e22293b0d0a7072696e746628225831203d20252e32665c6e222c5831293b0d0a7072696e746628225832203d20252e32665c6e222c5832293b0d0a7d0d0a0d0a72657475726e20303b0d0a0d0a7d);

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
  `salt` varchar(255) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1',
  `username` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `monitores`
--

INSERT INTO `monitores` (`id`, `turma_id`, `papel_id`, `matricula`, `email`, `nome`, `semestre`, `ano`, `senha`, `salt`, `ativo`, `status`, `username`) VALUES
(3, 1, 3, '12345Monitor', 'monitor@alg.com', 'testes', 2, 2017, 'fa0f6e2099c13664964316706f11e1df39c0a169dc43bab85402ef5d502f8eb3b8d8df4f5bf0a50e82c2ac3c199e9ee424ce5a97bf0590c987a28e69f0b250d9', '31eb5262c3ba0053d6e0b68680d924a3c998a7a2fbfd71adafbb1fbe1b2a67207c2aa7f2c17e9aa128dbe74e63424ca13716766a511e340485089916facb9bfa', 0, 1, 'montor01');

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
  `salt` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `professores`
--

INSERT INTO `professores` (`id`, `nome`, `username`, `papel_id`, `matricula`, `senha`, `salt`, `email`, `ativo`, `status`) VALUES
(1, 'Cimara Souza1', 'Cimara', 1, '80000123', '26aa203b9196c7989d1388cd393c3879d5eb69453376a7be0b1db46e31eac19d6b0934dfa780080cc5b482c68d563c010eeadb71981215a46b0f63797380a4a2', '6274ea1a70c4bc2d2c98d8fcc66499f981b83cf3983438809958049fa33cb3f2df4541fcca33bcde244494968887052ce9bf57ebb37651357ac2613bd7add655', 'deigon_prates@hotmail.com', 1, 1);

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
  `valor` float NOT NULL,
  `numero` int(11) NOT NULL,
  `pergunta` blob NOT NULL,
  `alternativa_a` blob,
  `alternativa_b` blob,
  `alternativa_c` blob,
  `alternativa_d` blob,
  `alternativa_e` blob,
  `status` int(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `registros`
--

CREATE TABLE `registros` (
  `id` int(11) NOT NULL,
  `turma_id` int(11) NOT NULL,
  `aluno_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `respostas`
--

CREATE TABLE `respostas` (
  `id` int(11) NOT NULL,
  `questao_id` int(11) NOT NULL,
  `resposta` blob NOT NULL,
  `resultado` tinyint(1) DEFAULT NULL,
  `comentario` blob
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
(1, '123', 'Cimara Souza1', 'algoritmo01', 2017, 1, 1);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_alunos_atividades_aluno_id` (`aluno_id`),
  ADD KEY `fk_alunos_atividades_avaliacao_id` (`avaliacao_id`);

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
-- Indexes for table `exemplos`
--
ALTER TABLE `exemplos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_exemplos_niveis_idx` (`niveis_id`);

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
  ADD KEY `fk_matricula_alunos1_idx` (`aluno_id`);

--
-- Indexes for table `respostas`
--
ALTER TABLE `respostas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_respostas_questoes1_idx` (`questao_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `alunos_atividades`
--
ALTER TABLE `alunos_atividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `atividades`
--
ALTER TABLE `atividades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `exemplos`
--
ALTER TABLE `exemplos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `monitores`
--
ALTER TABLE `monitores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tentativas_login`
--
ALTER TABLE `tentativas_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
  ADD CONSTRAINT `fk_alunos_atividades_aluno_id` FOREIGN KEY (`aluno_id`) REFERENCES `alunos` (`id`),
  ADD CONSTRAINT `fk_alunos_atividades_avaliacao_id` FOREIGN KEY (`avaliacao_id`) REFERENCES `atividades` (`id`);

--
-- Limitadores para a tabela `atividades`
--
ALTER TABLE `atividades`
  ADD CONSTRAINT `fk_avaliacoes_tipo1` FOREIGN KEY (`tipo_id`) REFERENCES `tipos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_avaliacoes_turma1` FOREIGN KEY (`turma_id`) REFERENCES `turmas` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `exemplos`
--
ALTER TABLE `exemplos`
  ADD CONSTRAINT `fk_exemplos_niveis` FOREIGN KEY (`niveis_id`) REFERENCES `niveis` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

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
-- Limitadores para a tabela `respostas`
--
ALTER TABLE `respostas`
  ADD CONSTRAINT `fk_respostas_questoes1` FOREIGN KEY (`questao_id`) REFERENCES `questoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `solucoes`
--
ALTER TABLE `solucoes`
  ADD CONSTRAINT `fk_gabaritos_questoes1` FOREIGN KEY (`questoes_id`) REFERENCES `questoes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
