
-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 21-Ago-2013 às 02:50
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
-- Estrutura da tabela `tipo_acesso`
--

CREATE TABLE IF NOT EXISTS `tipo_acesso` (
  `id_tipo_acesso` varchar(11) NOT NULL,
  `descricao_tipo_acesso` varchar(20) NOT NULL,
  PRIMARY KEY (`id_tipo_acesso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `tipo_acesso`
--

INSERT INTO `tipo_acesso` (`id_tipo_acesso`, `descricao_tipo_acesso`) VALUES
('admin', 'Administrador'),
('member', 'Membro'),
('user', 'Usuário');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;