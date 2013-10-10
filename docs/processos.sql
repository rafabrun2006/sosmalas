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
  `status_processo_text` varchar(255) NOT NULL,
  PRIMARY KEY (`id_processo`),
  KEY `pessoa_entrada` (`pessoa_entrada`),
  KEY `id_status_processo` (`status_processo_text`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=375 ;
