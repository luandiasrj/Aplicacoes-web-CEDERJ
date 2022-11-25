-- 
-- Table structure for table `produto`
-- 

DROP TABLE IF EXISTS `produto`;
CREATE TABLE `produto` (
  `id` int(11) NOT NULL auto_increment COMMENT 'Chave Primaria',
  `descricao` varchar(30) NOT NULL COMMENT 'Descrição do Produto',
  `preco` decimal(10,2) NOT NULL COMMENT 'Preço Unitário',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- 
-- Dumping data for table `produto`
-- 

INSERT INTO `produto` (`id`, `descricao`, `preco`) VALUES (1, 'Televisão', 950.00),
(2, 'Monitor CRT', 400.00),
(3, 'Computador Pessoal A', 1500.00),
(4, 'Computador Pessoal B', 2400.00),
(5, 'Mouse Comum', 20.00),
(6, 'Mouse Ótico', 60.00),
(7, 'PDA marca A', 300.00),
(8, 'PDA marca B', 950.00),
(9, 'Alto-falantes', 100.00),
(10, 'Telefone', 50.00),
(11, 'Impressora Laser', 1200.00),
(12, 'Memória Chaveiro 128 MB', 140.00);
