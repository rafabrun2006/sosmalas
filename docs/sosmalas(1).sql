-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Jun 28, 2013 as 03:38 AM
-- Versão do Servidor: 5.1.50
-- Versão do PHP: 5.3.9-ZS5.6.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `sosmalas`
--
CREATE DATABASE `sosmalas` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `sosmalas`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coletas`
--

CREATE TABLE IF NOT EXISTS `coletas` (
  `os_coleta` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` varchar(30) NOT NULL,
  `data_pedido_coleta` date DEFAULT NULL,
  `pcm_coleta` varchar(30) NOT NULL,
  `previsao_coleta` date DEFAULT NULL,
  `tipo_coleta` varchar(30) NOT NULL,
  `status_coleta` varchar(20) NOT NULL,
  PRIMARY KEY (`os_coleta`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Extraindo dados da tabela `coletas`
--

INSERT INTO `coletas` (`os_coleta`, `cliente_id`, `data_pedido_coleta`, `pcm_coleta`, `previsao_coleta`, `tipo_coleta`, `status_coleta`) VALUES
(89, '2', '2013-06-28', 'asdf', '2013-06-04', 'asdf', '1'),
(10, 'Costa e Silva', NULL, 'não sei', NULL, 'teste', 'aguardando peça'),
(24, 'Sosmalas', NULL, 'asdf', NULL, 'asdf', 'aguardando peça'),
(30, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'hoje'),
(29, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'asdf'),
(31, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'E-mail'),
(32, 'Fast help', NULL, 'também não sei', NULL, 'teste', 'em transporte'),
(33, 'Costa e Silva', NULL, 'não sei', NULL, 'teste', 'aguardando peça'),
(34, 'Sosmalas', NULL, 'asdf', NULL, 'asdf', 'aguardando peça'),
(35, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'hoje'),
(36, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'asdf'),
(37, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'E-mail'),
(52, 'Costa e Silva', NULL, 'não sei', NULL, 'teste', 'aguardando peça'),
(51, 'Fast help', NULL, 'também não sei', NULL, 'teste', 'em transporte'),
(53, 'Sosmalas', NULL, 'asdf', NULL, 'asdf', 'aguardando peça'),
(54, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'hoje'),
(55, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'asdf'),
(56, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'E-mail'),
(69, '', NULL, '', NULL, '', ''),
(70, 'Fast help', NULL, 'também não sei', NULL, 'teste', 'em transporte'),
(71, 'Costa e Silva', NULL, 'não sei', NULL, 'teste', 'aguardando peça'),
(72, 'Sosmalas', NULL, 'asdf', NULL, 'asdf', 'aguardando peça'),
(73, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'hoje'),
(74, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'asdf'),
(75, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'E-mail'),
(90, 'Luis Thiago', NULL, 'asdf', NULL, 'asdf', 'll'),
(95, '4', '2013-06-02', 'pcm', '2013-06-26', 'tipo', '1'),
(98, '1', '2013-06-11', 'pcm', '2013-06-18', 'tipo', '4'),
(99, '2', '2013-06-19', 'pcm', '2013-06-17', 'tipo', '2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrada`
--

CREATE TABLE IF NOT EXISTS `entrada` (
  `id_entrada` int(11) NOT NULL AUTO_INCREMENT,
  `data_entrada` varchar(20) NOT NULL,
  `empresa_entrada` varchar(20) NOT NULL,
  `processo_entrada` int(11) NOT NULL,
  `marca_entrada` varchar(20) NOT NULL,
  `nome_entrada` varchar(20) NOT NULL,
  `dano_entrada` varchar(20) NOT NULL,
  `preco_entrada` varchar(20) NOT NULL,
  `data_conclusao_entrada` varchar(20) NOT NULL,
  `data_previsao_entrada` varchar(20) NOT NULL,
  `data_entrega_entrada` varchar(20) NOT NULL,
  PRIMARY KEY (`id_entrada`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `entrada`
--

INSERT INTO `entrada` (`id_entrada`, `data_entrada`, `empresa_entrada`, `processo_entrada`, `marca_entrada`, `nome_entrada`, `dano_entrada`, `preco_entrada`, `data_conclusao_entrada`, `data_previsao_entrada`, `data_entrega_entrada`) VALUES
(1, 'cccc', 'bbbbbbbb', 0, 'aaaaaaaa', 'aaaaaaa', 'aaaaaaaa', 'aaaaaaa', 'aaaaaa', 'aaaaaaa', 'aaaaaaa'),
(2, 'cccc', 'bbbbbbbb', 0, 'aaaaaaaa', 'aaaaaaa', 'aaaaaaaa', 'aaaaaaa', 'aaaaaa', 'aaaaaaa', 'aaaaaaa');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pecas`
--

CREATE TABLE IF NOT EXISTS `pecas` (
  `id_peca` int(11) NOT NULL AUTO_INCREMENT,
  `descricao_peca` varchar(20) NOT NULL,
  `data_entrada_peca` date NOT NULL,
  `data_saida_peca` date NOT NULL,
  PRIMARY KEY (`id_peca`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Extraindo dados da tabela `pecas`
--

INSERT INTO `pecas` (`id_peca`, `descricao_peca`, `data_entrada_peca`, `data_saida_peca`) VALUES
(22, 'Luis Thiago', '0000-00-00', '0000-00-00');

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
  PRIMARY KEY (`id_pessoa`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `pessoa`
--

INSERT INTO `pessoa` (`id_pessoa`, `senha_pessoa`, `email_pessoa`, `nome_pessoa`, `tel_res_pessoa`, `tel_cel_pessoa`, `endereco_pessoa`, `ponto_ref_pessoa`) VALUES
(1, 'asdf', 'rafabrun2006@gmail.com', 'Rafael Bruno', '(55)5555-5555', '(55)5555-5555', 'quadra 10 lote 11', 'mercadinho'),
(2, 'asdf', 'rafabrun2006@gmail.com', 'Rafael Bruno de Sousa Oliveira', '(61)9903-1655', '(61)9232-0467', 'quadra 10 lote 11', 'Postinho de Saude'),
(4, 'asdf', 'thiago@email.com', 'Thiago Rodrigues', '(98)8888-8888', '(99)8988-7777', 'Endereço', 'Posto');

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_coleta`
--

CREATE TABLE IF NOT EXISTS `status_coleta` (
  `id_status_coleta` int(11) NOT NULL AUTO_INCREMENT,
  `nome_status_coleta` varchar(100) NOT NULL,
  PRIMARY KEY (`id_status_coleta`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Extraindo dados da tabela `status_coleta`
--

INSERT INTO `status_coleta` (`id_status_coleta`, `nome_status_coleta`) VALUES
(1, 'Recebido'),
(2, 'Em Concerto'),
(3, 'Concluído'),
(4, 'Não Concluído');
