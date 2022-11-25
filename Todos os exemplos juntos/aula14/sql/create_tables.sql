
-- Create tables
DROP TABLE IF EXISTS `autor`;
CREATE TABLE IF NOT EXISTS `autor` (
  `id` int(11) NOT NULL auto_increment,
  `nome` varchar(80) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `nome` (`nome`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

DROP TABLE IF EXISTS `emprestimo`;
CREATE TABLE IF NOT EXISTS `emprestimo` (
  `idlivro` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `datadevolucao` date NOT NULL,
  KEY `idlivro` (`idlivro`,`idusuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `escreveu`;
CREATE TABLE IF NOT EXISTS `escreveu` (
  `idlivro` int(11) NOT NULL,
  `idautor` int(11) NOT NULL,
  KEY `idlivro` (`idlivro`,`idautor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `livro`;
CREATE TABLE IF NOT EXISTS `livro` (
  `id` int(11) NOT NULL auto_increment,
  `titulo` varchar(120) NOT NULL,
  `exemplares` int(11) NOT NULL default '1',
  `genero` varchar(60) default NULL,
  `ano` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=470 ;

DROP TABLE IF EXISTS `solicitacao`;
CREATE TABLE IF NOT EXISTS `solicitacao` (
  `idlivro` int(11) NOT NULL,
  `idusuario` int(11) NOT NULL,
  `hora` datetime NOT NULL,
  KEY `idlivro` (`idlivro`,`idusuario`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL auto_increment,
  `nome` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(15) NOT NULL,
  `privilegio` varchar(15) default 'membro',
  `endereco` varchar(120) NOT NULL,
  `cidade` varchar(40) NOT NULL,
  `estado` char(2) NOT NULL,
  `telefone` varchar(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
