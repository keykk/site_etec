-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Máquina: 127.0.0.1
-- Data de Criação: 06-Ago-2014 às 17:50
-- Versão do servidor: 5.6.14
-- versão do PHP: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `b_etec`
--
CREATE DATABASE IF NOT EXISTS `b_etec` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `b_etec`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_categoria`
--

CREATE TABLE IF NOT EXISTS `etec_categoria` (
  `ca_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `ca_titulo` varchar(100) NOT NULL,
  `ca_desc` varchar(50) DEFAULT NULL,
  `ca_data` datetime NOT NULL,
  `ca_autoria` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`ca_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `etec_categoria`
--

INSERT INTO `etec_categoria` (`ca_codigo`, `ca_titulo`, `ca_desc`, `ca_data`, `ca_autoria`) VALUES
(1, 'Cursos tecnicos', 'cursos', '2014-06-18 15:54:35', 'gabriel bispo da silva'),
(2, 'Rodrigues', 'testeteste', '2014-06-29 23:58:43', 'gabriel bispo da silva'),
(3, 'test2', 'asdasdasd', '2014-07-10 13:26:36', 'gabriel bispo da silva'),
(4, 'test3', 'dadasdasd', '2014-07-10 13:26:44', 'gabriel bispo da silva'),
(5, 'teste5', 'SDASDASDASD', '2014-07-10 13:26:50', 'gabriel bispo da silva');

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_grupo`
--

CREATE TABLE IF NOT EXISTS `etec_grupo` (
  `g_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `g_nome` varchar(100) DEFAULT NULL,
  `g_data` date DEFAULT NULL,
  `g_privilegio` int(11) DEFAULT NULL,
  `autor` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`g_codigo`),
  KEY `g_privilegio` (`g_privilegio`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Extraindo dados da tabela `etec_grupo`
--

INSERT INTO `etec_grupo` (`g_codigo`, `g_nome`, `g_data`, `g_privilegio`, `autor`) VALUES
(1, 'Administrador', '2014-04-28', 1, 'BISPODASILVA'),
(11, 'novo grupo', '2014-06-18', 2, 'gabriel bispo da silva');

--
-- Acionadores `etec_grupo`
--
DROP TRIGGER IF EXISTS `relatar_grp_deleted`;
DELIMITER //
CREATE TRIGGER `relatar_grp_deleted` BEFORE DELETE ON `etec_grupo`
 FOR EACH ROW BEGIN
INSERT INTO etec_relatorio
SET r_relatorio= CONCAT('O Grupo => ',OLD.g_nome,' Criado por => ',OLD.autor,' Foi Excluido Permanentemente'),
r_data = NOW(),
r_id = 'etec_grupo',
r_obs = 'deleted'; END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `relatar_grp_insert`;
DELIMITER //
CREATE TRIGGER `relatar_grp_insert` AFTER INSERT ON `etec_grupo`
 FOR EACH ROW BEGIN
INSERT INTO etec_relatorio
SET r_relatorio= CONCAT('O Grupo => ',NEW.g_nome,' Foi cadastrado por => ',NEW.autor),
r_data = NOW(),
r_id = 'etec_grupo',
r_obs = 'insert'; END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `relatar_grp_up`;
DELIMITER //
CREATE TRIGGER `relatar_grp_up` BEFORE UPDATE ON `etec_grupo`
 FOR EACH ROW BEGIN
INSERT INTO etec_relatorio
SET r_relatorio = CONCAT('O Grupo => ',OLD.g_nome,' Criado por => ',OLD.autor,' Foi Alterado'),
r_data = NOW(),
r_id = 'etec_grupo',
r_obs = 'update'; END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_integra`
--

CREATE TABLE IF NOT EXISTS `etec_integra` (
  `in_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `in_titulo` varchar(90) NOT NULL,
  `in_conteudo` text NOT NULL,
  `in_data` datetime DEFAULT NULL,
  `in_data_on` datetime DEFAULT NULL,
  `in_data_off` datetime DEFAULT NULL,
  `in_autoria` varchar(90) DEFAULT NULL,
  `in_editor` varchar(90) DEFAULT NULL,
  `in_data_edicao` datetime DEFAULT NULL,
  `in_categoria` int(11) DEFAULT NULL,
  PRIMARY KEY (`in_codigo`),
  KEY `in_categoria` (`in_categoria`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `etec_integra`
--

INSERT INTO `etec_integra` (`in_codigo`, `in_titulo`, `in_conteudo`, `in_data`, `in_data_on`, `in_data_off`, `in_autoria`, `in_editor`, `in_data_edicao`, `in_categoria`) VALUES
(7, 'VESTIBULINHO 2014 - INSCRIÇÕES PRORROGADAS', '<p style="text-align: justify;"><span style="font-size: small;">* Inscri&ccedil;&otilde;es prorrogadas at&eacute; as 15h do dia 12/05/2014<br /> As  Escolas  T&eacute;cnicas  Estaduais  (Etecs)  do  Centro  Paula   Souza  est&atilde;o  de  portas  abertas  para  voc&ecirc;  que   terminou  o  Ensino  Fundamental e quer dar continuidade aos seus estudos. E tamb&eacute;m para  voc&ecirc;, que j&aacute; cursou ou est&aacute; fazendo o Ensino M&eacute;dio e busca ampliar suas  chances no mercado, aliando o aprendizado acad&ecirc;mico ao conhecimento  profissional.  Seja qual for o seu objetivo, o momento para decidir &eacute;  agora.</span></p>\r\n<p style="text-align: center;"><span style="font-size: small;"><img src="../../uploads/images/capa.jpg" alt="" width="300" height="423" /><img src="../../uploads/images/tras.jpg" alt="" width="290" height="421" /></span></p>\r\n<p style="text-align: center;">&nbsp;</p>\r\n<p style="text-align: justify;">&nbsp;</p>\r\n<h2><span style="font-size: small;"><a href="https://docs.google.com/forms/d/1Bali-ZvBENn6F4VsDLrslh1ad93dg01DxOd__zDnsc0/viewform" target="_blank">PARTICIPE DA PESQUISA</a></span></h2>\r\n<p><span style="font-size: small;"> </span></p>\r\n<p><span style="font-size: small;">A ETEC Rodrigues de Abreu apresenta algumas op&ccedil;&otilde;es para a  abertura de novo(s) curso(s). Assinale as op&ccedil;&otilde;es que voc&ecirc; pretende  ingressar.</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style="font-size: small;">...<br /></span></p>', '2014-07-02 11:00:43', '2014-07-02 11:00:00', '2014-08-29 22:00:00', 'gabriel bispo da silva', 'gabriel bispo da silva', '2014-07-31 11:16:42', 2),
(8, 'sadsadsadsadasdasdasdasda', '<p>asddasads</p>', '2014-07-17 13:47:10', '2014-07-16 13:45:00', '2014-07-20 13:45:00', 'gabriel bispo da silva', 'gabriel bispo da silva', '2014-07-17 14:08:10', 2),
(9, 'bispo', '<p>Testando apenas</p>', '2014-07-31 12:36:17', '2014-07-21 12:34:00', '2014-08-25 12:34:00', 'gabriel bispo da silva', 'gabriel bispo da silva', '2014-07-31 12:59:54', 2),
(10, 'bispodasilva', '<p>asdasd</p>', '2014-07-31 13:00:46', '2014-07-31 13:00:00', '2014-08-31 13:00:00', 'gabriel bispo da silva', NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_pagina`
--

CREATE TABLE IF NOT EXISTS `etec_pagina` (
  `pa_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `pa_titulo` varchar(90) NOT NULL,
  `pa_conteudo` text NOT NULL,
  `pa_autoria` varchar(80) DEFAULT NULL,
  `pa_data` datetime NOT NULL,
  `pa_edicao` datetime NOT NULL,
  `pa_editor` varchar(90) DEFAULT NULL,
  PRIMARY KEY (`pa_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;

--
-- Extraindo dados da tabela `etec_pagina`
--

INSERT INTO `etec_pagina` (`pa_codigo`, `pa_titulo`, `pa_conteudo`, `pa_autoria`, `pa_data`, `pa_edicao`, `pa_editor`) VALUES
(30, 'nova pagina', '<p><span style="font-size: medium;">Nova pagina</span></p>', 'gabriel bispo da silva', '2014-06-29 14:52:57', '2014-06-29 14:52:57', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_privilegio`
--

CREATE TABLE IF NOT EXISTS `etec_privilegio` (
  `p_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `p_nivel` int(11) DEFAULT NULL,
  `p_etc` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`p_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `etec_privilegio`
--

INSERT INTO `etec_privilegio` (`p_codigo`, `p_nivel`, `p_etc`) VALUES
(1, 10, 'Privilegio maximo (majoritario)'),
(2, 9, 'Criação, paginas, Noticias, Categorias');

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_relatorio`
--

CREATE TABLE IF NOT EXISTS `etec_relatorio` (
  `r_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `r_relatorio` text,
  `r_data` datetime DEFAULT NULL,
  `r_id` varchar(100) DEFAULT NULL,
  `r_obs` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`r_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Extraindo dados da tabela `etec_relatorio`
--

INSERT INTO `etec_relatorio` (`r_codigo`, `r_relatorio`, `r_data`, `r_id`, `r_obs`) VALUES
(1, 'O Grupo => test2 Foi Alterado', '2014-05-22 19:38:42', 'etec_grupo', 'update'),
(4, 'O Grupo => huehueteste Foi cadastrado por => SEM', '2014-05-22 20:01:14', 'etec_grupo', 'insert'),
(5, 'O Grupo => huehueteste Criado por => SEM Foi Excluido Permanentemente', '2014-05-22 20:05:46', 'etec_grupo', 'deleted'),
(8, 'Novo usuario => leticia hellen teste, Foi cadastrado por => gabriel bispo da silva, Pertence ao Grupo => testee', '2014-05-22 20:29:50', 'etec_usuario', 'insert'),
(11, 'Usuario => leticia hellen fernandess, Criado por => gabriel bispo da silva, Membro do grupo => testee, Alterou seus dados', '2014-05-22 20:48:50', 'etec_usuario', 'update'),
(12, 'O Grupo => uuuu Foi cadastrado por => gabriel bispo da silva', '2014-05-22 20:49:42', 'etec_grupo', 'insert'),
(13, 'O Grupo => uuuu Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-05-22 20:50:17', 'etec_grupo', 'deleted'),
(14, 'O Grupo => testee Criado por => BISPODASILVA Foi Alterado', '2014-06-17 15:02:12', 'etec_grupo', 'update'),
(15, 'O Grupo => testee Criado por => BISPODASILVA Foi Alterado', '2014-06-17 15:02:21', 'etec_grupo', 'update'),
(16, 'O Grupo => testeei Criado por => BISPODASILVA Foi Excluido Permanentemente', '2014-06-18 12:51:44', 'etec_grupo', 'deleted'),
(17, 'O Grupo => test2 Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-18 12:53:04', 'etec_grupo', 'deleted'),
(18, 'O Grupo => test3 Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-18 12:53:13', 'etec_grupo', 'deleted'),
(19, 'O Grupo => teste4 Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-18 12:53:23', 'etec_grupo', 'deleted'),
(20, 'O Grupo => teste5 Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-18 12:53:27', 'etec_grupo', 'deleted'),
(21, 'O Grupo => teste7 Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-18 12:53:36', 'etec_grupo', 'deleted'),
(22, 'O Grupo => teste6 Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-18 12:53:40', 'etec_grupo', 'deleted'),
(23, 'O Grupo => novo grupo Foi cadastrado por => gabriel bispo da silva', '2014-06-18 12:57:15', 'etec_grupo', 'insert'),
(24, 'Usuario => BISPODASILVA, Criado por => NONE, Membro do grupo => Administrador, Alterou seus dados', '2014-06-18 13:20:10', 'etec_usuario', 'update'),
(25, 'O Grupo => teste Foi cadastrado por => gabriel bispo da silva', '2014-06-20 21:23:21', 'etec_grupo', 'insert'),
(26, 'O Grupo => teste Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-20 21:25:55', 'etec_grupo', 'deleted'),
(27, 'O Grupo => teste Foi cadastrado por => gabriel bispo da silva', '2014-06-20 21:27:18', 'etec_grupo', 'insert'),
(28, 'O Grupo => teste Criado por => gabriel bispo da silva Foi Excluido Permanentemente', '2014-06-21 12:16:18', 'etec_grupo', 'deleted'),
(29, 'Usuario => BISPODASILVA, Criado por => NONE, Membro do grupo => novo grupo, Alterou seus dados', '2014-06-29 14:13:47', 'etec_usuario', 'update');

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_usuario`
--

CREATE TABLE IF NOT EXISTS `etec_usuario` (
  `u_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `u_login` varchar(100) NOT NULL,
  `u_senha` varchar(100) NOT NULL,
  `u_datanasc` date NOT NULL,
  `u_dataregistro` date NOT NULL,
  `u_cpf` varchar(100) NOT NULL,
  `u_nome` varchar(100) NOT NULL,
  `u_sexo` varchar(20) NOT NULL,
  `u_email` varchar(100) NOT NULL,
  `u_autor` varchar(100) NOT NULL,
  `u_grupo` int(11) NOT NULL,
  `u_apelido` varchar(100) DEFAULT NULL,
  `u_pagina` text NOT NULL,
  PRIMARY KEY (`u_codigo`),
  KEY `u_grupo` (`u_grupo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Extraindo dados da tabela `etec_usuario`
--

INSERT INTO `etec_usuario` (`u_codigo`, `u_login`, `u_senha`, `u_datanasc`, `u_dataregistro`, `u_cpf`, `u_nome`, `u_sexo`, `u_email`, `u_autor`, `u_grupo`, `u_apelido`, `u_pagina`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', '1996-03-01', '2014-04-28', '111.111.111-11', 'BISPODASILVA', 'Male', 'gabrielsilva-10@hotmail.com', 'NONE', 1, 'Gabriel bispo', ''),
(5, '81283331', 'c96cc1b411047724f2e2294a39162756', '1996-03-01', '2014-05-16', '444.327.458-86', 'gabriel bispo da silva', 'Masculino', 'gabrielsilva-10@outlook.com', 'BISPODASILVA', 1, 'bispodasilva', '<p style="text-align: center;"><span style="font-size: medium;">teste</span></p>');

--
-- Acionadores `etec_usuario`
--
DROP TRIGGER IF EXISTS `relatar_user_deleted`;
DELIMITER //
CREATE TRIGGER `relatar_user_deleted` BEFORE DELETE ON `etec_usuario`
 FOR EACH ROW BEGIN
INSERT INTO etec_relatorio
SET r_relatorio= CONCAT('Usuarioo => ',OLD.u_nome,', Criado por => ',OLD.u_autor,', Membro do Grupo => ',(SELECT g_nome FROM etec_grupo WHERE g_codigo = OLD.u_grupo), ', Foi Excluido'),
r_data = NOW(),
r_id = 'etec_usuario',
r_obs = 'deleted'; END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `relatar_user_insert`;
DELIMITER //
CREATE TRIGGER `relatar_user_insert` AFTER INSERT ON `etec_usuario`
 FOR EACH ROW BEGIN
INSERT INTO etec_relatorio
SET r_relatorio= CONCAT('Novo usuario => ',NEW.u_nome,', Foi cadastrado por => ',NEW.u_autor,', Pertence ao Grupo => ',(SELECT g_nome FROM etec_grupo WHERE g_codigo = NEW.u_grupo)),
r_data = NOW(),
r_id = 'etec_usuario',
r_obs = 'insert'; END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `relatar_user_up`;
DELIMITER //
CREATE TRIGGER `relatar_user_up` BEFORE UPDATE ON `etec_usuario`
 FOR EACH ROW BEGIN
INSERT INTO etec_relatorio
SET r_relatorio = CONCAT('Usuario => ',OLD.u_nome,', Criado por => ',OLD.u_autor,', Membro do grupo => ',(SELECT g_nome FROM etec_grupo WHERE g_codigo = OLD.u_grupo), ', Alterou seus dados'),
r_data = NOW(),
r_id = 'etec_usuario',
r_obs = 'update'; END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etec_wowslide`
--

CREATE TABLE IF NOT EXISTS `etec_wowslide` (
  `w_codigo` int(11) NOT NULL AUTO_INCREMENT,
  `w_slide` text NOT NULL,
  `w_data` datetime DEFAULT NULL,
  `w_titulo` varchar(80) NOT NULL,
  `w_link` varchar(300) DEFAULT NULL,
  `w_autor` int(11) DEFAULT NULL,
  `w_editor` int(11) DEFAULT NULL,
  `w_ativacao` datetime DEFAULT NULL,
  `w_desativacao` datetime DEFAULT NULL,
  PRIMARY KEY (`w_codigo`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `etec_wowslide`
--

INSERT INTO `etec_wowslide` (`w_codigo`, `w_slide`, `w_data`, `w_titulo`, `w_link`, `w_autor`, `w_editor`, `w_ativacao`, `w_desativacao`) VALUES
(7, 'wowslider/d1a3c0fc690990ea77cfc11e38159d5a.jpg', '2014-08-06 11:03:01', 'etec - rodrigues de abreu', 'privado', 5, 5, '2014-08-06 11:00:00', '2014-08-07 13:00:00'),
(8, 'wowslider/0da7a9e5306365911eb6700299efbf7e.jpg', '2014-08-06 11:03:40', 'teste', '#', 5, 1, '2014-08-06 11:00:00', '2014-08-20 13:00:00'),
(9, 'wowslider/4014701d679ab7ca4ed70b66946b56ea.jpg', '2014-08-06 11:04:33', 'teste2', '#', 5, 5, '2014-08-06 11:06:00', '2014-08-25 13:00:00'),
(10, 'wowslider/1aed8f650644c14c1bdf9fc9502971cb.jpg', '2014-08-06 11:49:36', 'hedynho', 'http://www.google.com', 1, NULL, '2014-08-06 11:51:00', '2014-08-10 13:00:00');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `etec_grupo`
--
ALTER TABLE `etec_grupo`
  ADD CONSTRAINT `etec_grupo_ibfk_1` FOREIGN KEY (`g_privilegio`) REFERENCES `etec_privilegio` (`p_codigo`);

--
-- Limitadores para a tabela `etec_integra`
--
ALTER TABLE `etec_integra`
  ADD CONSTRAINT `etec_integra_ibfk_1` FOREIGN KEY (`in_categoria`) REFERENCES `etec_categoria` (`ca_codigo`);

--
-- Limitadores para a tabela `etec_usuario`
--
ALTER TABLE `etec_usuario`
  ADD CONSTRAINT `etec_usuario_ibfk_1` FOREIGN KEY (`u_grupo`) REFERENCES `etec_grupo` (`g_codigo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
