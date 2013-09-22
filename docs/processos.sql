-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 22-Set-2013 às 04:45
-- Versão do servidor: 5.5.23
-- versão do PHP: 5.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `sosmalas`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `processos`
--

CREATE TABLE IF NOT EXISTS `processos` (
  `id_processo` int(11) NOT NULL AUTO_INCREMENT,
  `os_processo` int(20) NOT NULL,
  `nome_pax_processo` varchar(250) NOT NULL,
  `qtd_bagagem_processo` int(11) NOT NULL,
  `servico_realizado_processo` varchar(250) NOT NULL,
  `data_coleta_processo` date DEFAULT NULL,
  `data_entrega_processo` date DEFAULT NULL,
  `obs_processo` varchar(250) NOT NULL,
  `pessoa_entrada` int(11) NOT NULL,
  `status_processo_id` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_processo`),
  KEY `pessoa_entrada` (`pessoa_entrada`),
  KEY `id_status_processo` (`status_processo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=375 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `processos`
--
ALTER TABLE `processos`
  ADD CONSTRAINT `processos_ibfk_2` FOREIGN KEY (`status_processo_id`) REFERENCES `status_processo` (`id_status_processo`),
  ADD CONSTRAINT `processos_ibfk_1` FOREIGN KEY (`pessoa_entrada`) REFERENCES `pessoa` (`id_pessoa`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
