CREATE TABLE `usuario` (
  `userID` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `sobrenome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `dataHoraRegistro` datetime DEFAULT CURRENT_TIMESTAMP,
  `statusConta` ENUM('ativa', 'desativada') DEFAULT 'ativa',
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `aquisicoes` (
  `aquisicaoID` int(11) NOT NULL AUTO_INCREMENT,
  `produtoID` int(11) DEFAULT NULL,
  `chatID` int(11) DEFAULT NULL,
  `compradorID` int(11) DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `vendedorID` int(11) DEFAULT NULL,
  `statusAquisicao` datetime DEFAULT NULL,
  PRIMARY KEY (`aquisicaoID`),
  FOREIGN KEY (`produtoID`) REFERENCES `produto` (`produtoID`),
  FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`),
  FOREIGN KEY (`compradorID`) REFERENCES `usuario` (`userID`),
  FOREIGN KEY (`vendedorID`) REFERENCES `usuario` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `categoria` (
  `categoriaID` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`categoriaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `chat` (
  `chatID` int(11) NOT NULL AUTO_INCREMENT,
  `produtoID` int(11) DEFAULT NULL,
  `compradorID` int(11) DEFAULT NULL,
  `vendedorID` int(11) DEFAULT NULL,
  `dataInicioChat` datetime DEFAULT NULL,
  PRIMARY KEY (`chatID`),
  FOREIGN KEY (`produtoID`) REFERENCES `produto` (`produtoID`),
  FOREIGN KEY (`compradorID`) REFERENCES `usuario` (`userID`),
  FOREIGN KEY (`vendedorID`) REFERENCES `usuario` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `comprapagamento` (
  `compraID` int(11) NOT NULL AUTO_INCREMENT,
  `aquisicaoID` int(11) DEFAULT NULL,
  `nomeCompleto` varchar(255) DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `chavePix` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`compraID`),
  FOREIGN KEY (`aquisicaoID`) REFERENCES `aquisicoes` (`aquisicaoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `linkcompra` (
  `linkCompraID` int(11) NOT NULL AUTO_INCREMENT,
  `chatID` int(11) DEFAULT NULL,
  `valorBrutoCompra` decimal(7,2) DEFAULT NULL,
  `valorCompra` decimal(7,2) DEFAULT NULL,
  `statusLinkCompra` enum('pendente','aceito','recusado','cancelado') NOT NULL DEFAULT 'pendente',
  `valorFrete` decimal(7,2) DEFAULT NULL,
  `dataHora` datetime DEFAULT CURRENT_TIMESTAMP,
  `produtoID` int(11) DEFAULT NULL,
  PRIMARY KEY (`linkCompraID`),
  FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`),
  FOREIGN KEY (`produtoID`) REFERENCES `produto` (`produtoID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `mensagem` (
  `mensagemID` int(11) NOT NULL AUTO_INCREMENT,
  `conteudo` varchar(255) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `chatID` int(11) DEFAULT NULL,
  `linkcompra` int(11) DEFAULT NULL,
  PRIMARY KEY (`mensagemID`),
  FOREIGN KEY (`userID`) REFERENCES `usuario` (`userID`),
  FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`),
  FOREIGN KEY (`linkcompra`) REFERENCES `linkcompra` (`linkCompraID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `notificacao` (
  `notificacaoID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `conteudo` text DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `destinatarioID` int(11) NOT NULL,
  `chatID` int(11) NOT NULL,
  PRIMARY KEY (`notificacaoID`),
  FOREIGN KEY (`userID`) REFERENCES `usuario` (`userID`),
  FOREIGN KEY (`destinatarioID`) REFERENCES `usuario` (`userID`),
  FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `produto` (
  `produtoID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `categoriaID` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `condicao` varchar(255) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `disponibilidade` varchar(255) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `locImagem` varchar(255) DEFAULT NULL,
  `dataHoraPub` datetime DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `visualizacao` int(11) DEFAULT 0,
  PRIMARY KEY (`produtoID`),
  FOREIGN KEY (`userID`) REFERENCES `usuario` (`userID`),
  FOREIGN KEY (`categoriaID`) REFERENCES `categoria` (`categoriaID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
