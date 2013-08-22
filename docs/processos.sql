-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Ago 05, 2013 as 02:47 AM
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
  `data_coleta_processo` date NOT NULL,
  `data_entrega_processo` text NOT NULL,
  `obs_processo` varchar(250) NOT NULL,
  `pessoa_entrada` int(11) NOT NULL,
  PRIMARY KEY (`id_processo`),
  KEY `pessoa_entrada` (`pessoa_entrada`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `processos`
--

INSERT INTO `processos` (`id_processo`, `os_processo`, `nome_pax_processo`, `qtd_bagagem_processo`, `servico_realizado_processo`, `data_coleta_processo`, `data_entrega_processo`, `obs_processo`, `pessoa_entrada`) VALUES
(1, 11, 'Pax', 11, 'Conserto', '2013-08-04', '2013-08-04', 'Observação', 1),
(2, 11, 'Pax', 11, 'Conserto', '2013-08-04', '2013-08-04', 'Observação', 1),
(3, 33, 'Pax', 99, 'Conserto', '2013-08-05', '2013-08-07', 'Observação', 1);

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `processos`
--
ALTER TABLE `processos`
  ADD CONSTRAINT `processos_ibfk_1` FOREIGN KEY (`pessoa_entrada`) REFERENCES `pessoa` (`id_pessoa`);
