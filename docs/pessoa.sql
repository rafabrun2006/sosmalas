-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 21-Ago-2013 às 02:51
-- Versão do servidor: 5.1.70-cll
-- versão do PHP: 5.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `sosmalas_sistema`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa`
--

CREATE TABLE IF NOT EXISTS `pessoa` (
  `id_pessoa` int(11) NOT NULL AUTO_INCREMENT,
  `senha_pessoa` varchar(20) CHARACTER SET utf8 NOT NULL,
  `email_pessoa` varchar(80) CHARACTER SET utf8 NOT NULL,
  `nome_pessoa` varchar(80) NOT NULL,
  `tel_res_pessoa` varchar(13) NOT NULL COMMENT 'Telefone residencial do cliente',
  `tel_cel_pessoa` varchar(13) NOT NULL,
  `endereco_pessoa` varchar(150) NOT NULL,
  `ponto_ref_pessoa` varchar(250) NOT NULL,
  `cod_tipo_acesso` int(11) DEFAULT NULL,
  `tx_tipo_acesso` varchar(10) NOT NULL,
  PRIMARY KEY (`id_pessoa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `senha_pessoa`, `email_pessoa`, `nome_pessoa`, `tel_res_pessoa`, `tel_cel_pessoa`, `endereco_pessoa`, `ponto_ref_pessoa`, `cod_tipo_acesso`, `tx_tipo_acesso`) VALUES
(1, 'ranelore', 'rafabrun2006@gmail.com', 'Rafael Bruno de Sousa Oliveira', '(77)7777-7777', '(55)5555-5555', 'quadra 10 lote 11', 'mercadinho', 0, 'admin'),
(5, 'lita0603', 'adelita@sosmalas.com.br', 'Adelita', '(61)3393-9909', '(61)9159-9000', 'Santa Maria', '419', NULL, 'admin'),
(7, 'tam123', 'bsbll02@tam.com.br', 'TAM', '(61)3364-9797', '(61)0000-0000', 'aerporto', 'aeroporto', NULL, 'member'),
(8, 'copa123', 'aalves@copaair.com', 'COPA', '(66)6666-6666', '(66)6666-6666', 'aerporto', 'aeroporto', NULL, 'member'),
(12, 'thiago', 'luisthiago.ti@gmail.com', 'Luis Thiago Araújo', '(61)3385-4521', '(61)8187-2716', 'Quadra 15 Conjunto F casa 13', 'Ao lado do campo de terra \\\\\\"tupy\\\\\\"', NULL, 'admin'),
(13, 'empresa', 'azul@azul.com.br', 'azulimmmm', '(61)3333-3333', '(61)9999-9999', 'endereço', 'ponto', NULL, 'member'),
(15, 'sergio221100', 'sergiocaldas@sosmalas.com.br', 'Sergio Caldas', '(61)3393-9909', '(61)8433-0212', 'AC 419 Conjunto D Lote 11', 'BR 040', NULL, 'admin'),
(16, 'meikinha', 'contato@sosmalas.com.br', 'Elles Meike', '(61)3393-9909', '(00)0000-0000', 'Santa Maria', '419', NULL, 'admin'),
(17, 'taca123', 'taca@taca.com.br', 'TACA', '(61)3364-0000', '(61)0000-0000', 'AEROPORTO', 'BSB', NULL, 'member'),
(18, 'azul123', 'll.bsb@voeazul.com.br', 'AZUL', '(61)3364-9412', '(61)3364-0000', 'BSB', 'AEROPORTO', NULL, 'member'),
(19, 'aerolineas123', 'bsbtrar@voeaerolineas.com.br', 'AEROLINEAS ARGENTINAS', '(61)3364-0000', '(61)3364-0000', 'BSB', 'AEROPORTO', NULL, 'member'),
(20, 'american123', 'american@american.com.br', 'AMERICAN', '(61)3364-9474', '(61)3364-9474', 'BSB', 'AEROPORTO', NULL, 'member'),
(21, 'avianca123', 'avianca@avianca.com.br', 'AVIANCA', '(61)3364-0000', '(61)3364-0000', 'BSB', 'AEROPORTO', NULL, 'member'),
(22, 'passaredo123', 'passaredo@passaredo.com.br', 'PASSAREDO', '(61)3364-0000', '(61)3364-0000', 'BSB ', 'AEROPORTO', NULL, 'member');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
