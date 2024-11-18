<<<<<<< HEAD
-- Criar o banco de dados
CREATE DATABASE metache;

-- Usar o banco de dados criado
USE metache;

-- Tabela Tipo
CREATE TABLE Tipo (
    tipoID INT PRIMARY KEY,
    tipo VARCHAR(255)
);

-- Tabela Categoria
CREATE TABLE Categoria (
    categoriaID INT PRIMARY KEY,
    categoria VARCHAR(255)
);

-- Tabela Usuario
CREATE TABLE Usuario (
    userID INT PRIMARY KEY,
    nome VARCHAR(255),
    sobrenome VARCHAR(255),
    email VARCHAR(255),
    senha VARCHAR(255),
    cep VARCHAR(255),
    dataHoraRegistro DATETIME
);

-- Tabela Produto
CREATE TABLE Produto (
    produtoID INT PRIMARY KEY,
    userID INT,
    categoriaID INT,
    titulo VARCHAR(255),
    condicao VARCHAR(255),
    descricao VARCHAR(255),
    disponibilidade VARCHAR(255),
    valor DECIMAL(10,2),
    lojamercado VARCHAR(255),
    dataHoraPub DATETIME,
    localizacao VARCHAR(255)
);

-- Tabela LinkCompra
CREATE TABLE LinkCompra (
    linkCompraID INT PRIMARY KEY,
    chatID INT,
    valorBrutoCompra DECIMAL(7,2),
    valorCompra DECIMAL(7,2),
    statusLinkCompra VARCHAR(255),
    valorFrete DECIMAL(7,2)
);

-- Tabela Chat
CREATE TABLE Chat (
    chatID INT PRIMARY KEY,
    produtoID INT,
    userID INT,
    compradorID INT,
    dataInicioChat DATETIME
);

-- Tabela Mensagem
CREATE TABLE Mensagem (
    mensagemID INT PRIMARY KEY,
    conteudo VARCHAR(255),
    destinatarioID INT,
    dataHora DATETIME
);

-- Tabela Aquisicoes
CREATE TABLE Aquisicoes (
    aquisicaoID INT PRIMARY KEY,
    produtoID INT,
    chatID INT,
    userID INT,
    dataHora DATETIME,
    remetente VARCHAR(255),
    statusAquisicao DATETIME
);

-- Tabela CompraPagamento
CREATE TABLE CompraPagamento (
    compraID INT PRIMARY KEY,
    aquisicaoID INT,
    nomeCompleto VARCHAR(255),
    cpf VARCHAR(255),
    chavePix VARCHAR(255)
);

-- Tabela PesquisaAnuncio
CREATE TABLE PesquisaAnuncio (
    historicoUserID INT,
    produtoID INT,
    usuarioID INT,
    dataHora DATETIME,
    PRIMARY KEY (historicoUserID, produtoID)
);

-- Tabela Notificacao
CREATE TABLE Notificacao (
    notificacaoID INT PRIMARY KEY,
    userID INT,
    remetenteID INT,
    conteudo TEXT,
    dataHora DATETIME
);

-- Tabela OpiniaoAnunciante
CREATE TABLE OpiniaoAnunciante (
    opiniaoID INT PRIMARY KEY,
    userID INT,
    autor VARCHAR(255),
    texto TEXT,
    tipoOpiniao VARCHAR(255),
    data DATETIME,
    estrelas INT
);

-- Tabela Categoria_Tipo (Tabela de associação entre Tipo e Categoria)
CREATE TABLE Categoria_Tipo (
    tipoID INT,
    categoriaID INT,
    PRIMARY KEY (tipoID, categoriaID)
);

-- Alterações para adicionar as chaves estrangeiras

-- Relacionamento entre Produto e Usuario
ALTER TABLE Produto
ADD CONSTRAINT fk_produto_usuario
FOREIGN KEY (userID) REFERENCES Usuario(userID);

-- Relacionamento entre Produto e Categoria
ALTER TABLE Produto
ADD CONSTRAINT fk_produto_categoria
FOREIGN KEY (categoriaID) REFERENCES Categoria(categoriaID);

-- Relacionamento entre LinkCompra e Chat
ALTER TABLE LinkCompra
ADD CONSTRAINT fk_linkcompra_chat
FOREIGN KEY (chatID) REFERENCES Chat(chatID);

-- Relacionamento entre Chat e Produto
ALTER TABLE Chat
ADD CONSTRAINT fk_chat_produto
FOREIGN KEY (produtoID) REFERENCES Produto(produtoID);

-- Relacionamento entre Chat e Usuario (vendedor)
ALTER TABLE Chat
ADD CONSTRAINT fk_chat_usuario_vendedor
FOREIGN KEY (userID) REFERENCES Usuario(userID);

-- Relacionamento entre Chat e Usuario (comprador)
ALTER TABLE Chat
ADD CONSTRAINT fk_chat_usuario_comprador
FOREIGN KEY (compradorID) REFERENCES Usuario(userID);

-- Relacionamento entre Mensagem e Usuario (destinatário)
ALTER TABLE Mensagem
ADD CONSTRAINT fk_mensagem_destinatario
FOREIGN KEY (destinatarioID) REFERENCES Usuario(userID);

-- Relacionamento entre Aquisicoes e Produto
ALTER TABLE Aquisicoes
ADD CONSTRAINT fk_aquisicoes_produto
FOREIGN KEY (produtoID) REFERENCES Produto(produtoID);

-- Relacionamento entre Aquisicoes e Chat
ALTER TABLE Aquisicoes
ADD CONSTRAINT fk_aquisicoes_chat
FOREIGN KEY (chatID) REFERENCES Chat(chatID);

-- Relacionamento entre Aquisicoes e Usuario
ALTER TABLE Aquisicoes
ADD CONSTRAINT fk_aquisicoes_usuario
FOREIGN KEY (userID) REFERENCES Usuario(userID);

-- Relacionamento entre CompraPagamento e Aquisicoes
ALTER TABLE CompraPagamento
ADD CONSTRAINT fk_comprapagamento_aquisicoes
FOREIGN KEY (aquisicaoID) REFERENCES Aquisicoes(aquisicaoID);

-- Relacionamento entre PesquisaAnuncio e Produto
ALTER TABLE PesquisaAnuncio
ADD CONSTRAINT fk_pesquisaanuncio_produto
FOREIGN KEY (produtoID) REFERENCES Produto(produtoID);

-- Relacionamento entre PesquisaAnuncio e Usuario
ALTER TABLE PesquisaAnuncio
ADD CONSTRAINT fk_pesquisaanuncio_usuario
FOREIGN KEY (usuarioID) REFERENCES Usuario(userID);

-- Relacionamento entre Notificacao e Usuario (usuário que recebe a notificação)
ALTER TABLE Notificacao
ADD CONSTRAINT fk_notificacao_usuario
FOREIGN KEY (userID) REFERENCES Usuario(userID);

-- Relacionamento entre Notificacao e Usuario (remetente da notificação)
ALTER TABLE Notificacao
ADD CONSTRAINT fk_notificacao_remetente
FOREIGN KEY (remetenteID) REFERENCES Usuario(userID);

-- Relacionamento entre OpiniaoAnunciante e Usuario
ALTER TABLE OpiniaoAnunciante
ADD CONSTRAINT fk_opiniao_usuario
FOREIGN KEY (userID) REFERENCES Usuario(userID);

-- Relacionamento entre Categoria_Tipo e Tipo
ALTER TABLE Categoria_Tipo
ADD CONSTRAINT fk_categoriatipo_tipo
FOREIGN KEY (tipoID) REFERENCES Tipo(tipoID);

-- Relacionamento entre Categoria_Tipo e Categoria
ALTER TABLE Categoria_Tipo
ADD CONSTRAINT fk_categoriatipo_categoria
FOREIGN KEY (categoriaID) REFERENCES Categoria(categoriaID);



ALTER TABLE Usuario 
MODIFY COLUMN userID INT AUTO_INCREMENT;
=======
-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/10/2024 às 02:57
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `projetometache`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aquisicoes`
--

CREATE TABLE `aquisicoes` (
  `aquisicaoID` int(11) NOT NULL,
  `produtoID` int(11) DEFAULT NULL,
  `chatID` int(11) DEFAULT NULL,
  `compradorID` int(11) DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `vendedorID` int(11) DEFAULT NULL,
  `statusAquisicao` enum('finalizado','pendente','esperando envio') DEFAULT 'esperando envio'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categoria`
--

CREATE TABLE `categoria` (
  `categoriaID` int(11) NOT NULL,
  `categoria` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `chat`
--

CREATE TABLE `chat` (
  `chatID` int(11) NOT NULL,
  `produtoID` int(11) DEFAULT NULL,
  `compradorID` int(11) DEFAULT NULL,
  `vendedorID` int(11) DEFAULT NULL,
  `dataInicioChat` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comprapagamento`
--

CREATE TABLE `comprapagamento` (
  `compraID` int(11) NOT NULL,
  `aquisicaoID` int(11) DEFAULT NULL,
  `nomeCompleto` varchar(255) DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `chavePix` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `envioproduto`
--

CREATE TABLE `envioproduto` (
  `envioProdutoID` int(11) NOT NULL,
  `aquisicaoID` int(11) NOT NULL,
  `transportadora` varchar(255) DEFAULT NULL,
  `dataHora` datetime DEFAULT current_timestamp(),
  `codigoRastreio` varchar(255) DEFAULT NULL,
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `linkcompra`
--

CREATE TABLE `linkcompra` (
  `linkCompraID` int(11) NOT NULL,
  `chatID` int(11) DEFAULT NULL,
  `valorBrutoCompra` decimal(7,2) DEFAULT NULL,
  `valorCompra` decimal(7,2) DEFAULT NULL,
  `statusLinkCompra` enum('pendente','aceito','recusado','cancelado') NOT NULL DEFAULT 'pendente',
  `valorFrete` decimal(7,2) DEFAULT NULL,
  `dataHora` datetime DEFAULT current_timestamp(),
  `produtoID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagem`
--

CREATE TABLE `mensagem` (
  `mensagemID` int(11) NOT NULL,
  `conteudo` varchar(255) DEFAULT NULL,
  `userID` int(11) DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `chatID` int(11) DEFAULT NULL,
  `linkcompra` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notificacao`
--

CREATE TABLE `notificacao` (
  `notificacaoID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `null` int(11) DEFAULT NULL,
  `conteudo` text DEFAULT NULL,
  `dataHora` datetime DEFAULT NULL,
  `destinatarioID` int(11) NOT NULL,
  `chatID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `produtoID` int(11) NOT NULL,
  `userID` int(11) DEFAULT NULL,
  `categoriaID` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `condicao` enum('Novo','Usado','Vintage','Com defeito') DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `disponibilidade` enum('disponível','pausado','vendido') DEFAULT 'disponível',
  `valor` decimal(10,2) DEFAULT NULL,
  `locImagem` varchar(255) DEFAULT NULL,
  `dataHoraPub` datetime DEFAULT NULL,
  `localizacao` varchar(255) DEFAULT NULL,
  `visualizacao` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `userID` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `sobrenome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `cep` varchar(255) DEFAULT NULL,
  `dataHoraRegistro` datetime DEFAULT NULL,
  `statusConta` enum('ativa','desativada') NOT NULL DEFAULT 'ativa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aquisicoes`
--
ALTER TABLE `aquisicoes`
  ADD PRIMARY KEY (`aquisicaoID`),
  ADD KEY `fk_aquisicoes_produto` (`produtoID`),
  ADD KEY `fk_aquisicoes_chat` (`chatID`),
  ADD KEY `fk_aquisicoes_usuario` (`compradorID`);

--
-- Índices de tabela `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`categoriaID`);

--
-- Índices de tabela `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chatID`),
  ADD KEY `fk_chat_produto` (`produtoID`),
  ADD KEY `fk_chat_usuario_vendedor` (`compradorID`),
  ADD KEY `fk_vendedor_usuario` (`vendedorID`);

--
-- Índices de tabela `comprapagamento`
--
ALTER TABLE `comprapagamento`
  ADD PRIMARY KEY (`compraID`),
  ADD KEY `fk_comprapagamento_aquisicoes` (`aquisicaoID`);

--
-- Índices de tabela `envioproduto`
--
ALTER TABLE `envioproduto`
  ADD PRIMARY KEY (`envioProdutoID`),
  ADD KEY `aquisicaoID` (`aquisicaoID`);

--
-- Índices de tabela `linkcompra`
--
ALTER TABLE `linkcompra`
  ADD PRIMARY KEY (`linkCompraID`),
  ADD KEY `fk_linkcompra_chat` (`chatID`);

--
-- Índices de tabela `mensagem`
--
ALTER TABLE `mensagem`
  ADD PRIMARY KEY (`mensagemID`),
  ADD KEY `fk_mensagem_destinatario` (`userID`),
  ADD KEY `fk_chatID` (`chatID`);

--
-- Índices de tabela `notificacao`
--
ALTER TABLE `notificacao`
  ADD PRIMARY KEY (`notificacaoID`),
  ADD KEY `fk_notificacao_usuario` (`userID`),
  ADD KEY `fk_notificacao_remetente` (`null`),
  ADD KEY `destinatarioID` (`destinatarioID`),
  ADD KEY `chatID` (`chatID`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`produtoID`),
  ADD KEY `fk_produto_usuario` (`userID`),
  ADD KEY `fk_produto_categoria` (`categoriaID`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aquisicoes`
--
ALTER TABLE `aquisicoes`
  MODIFY `aquisicaoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categoria`
--
ALTER TABLE `categoria`
  MODIFY `categoriaID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `chat`
--
ALTER TABLE `chat`
  MODIFY `chatID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `envioproduto`
--
ALTER TABLE `envioproduto`
  MODIFY `envioProdutoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `linkcompra`
--
ALTER TABLE `linkcompra`
  MODIFY `linkCompraID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mensagem`
--
ALTER TABLE `mensagem`
  MODIFY `mensagemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notificacao`
--
ALTER TABLE `notificacao`
  MODIFY `notificacaoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `produtoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `aquisicoes`
--
ALTER TABLE `aquisicoes`
  ADD CONSTRAINT `fk_aquisicoes_chat` FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`),
  ADD CONSTRAINT `fk_aquisicoes_produto` FOREIGN KEY (`produtoID`) REFERENCES `produto` (`produtoID`),
  ADD CONSTRAINT `fk_aquisicoes_usuario` FOREIGN KEY (`compradorID`) REFERENCES `usuario` (`userID`);

--
-- Restrições para tabelas `chat`
--
ALTER TABLE `chat`
  ADD CONSTRAINT `fk_chat_produto` FOREIGN KEY (`produtoID`) REFERENCES `produto` (`produtoID`),
  ADD CONSTRAINT `fk_chat_usuario_comprador` FOREIGN KEY (`vendedorID`) REFERENCES `usuario` (`userID`),
  ADD CONSTRAINT `fk_chat_usuario_vendedor` FOREIGN KEY (`compradorID`) REFERENCES `usuario` (`userID`),
  ADD CONSTRAINT `fk_vendedor_usuario` FOREIGN KEY (`vendedorID`) REFERENCES `usuario` (`userID`);

--
-- Restrições para tabelas `envioproduto`
--
ALTER TABLE `envioproduto`
  ADD CONSTRAINT `envioproduto_ibfk_1` FOREIGN KEY (`aquisicaoID`) REFERENCES `aquisicoes` (`aquisicaoID`);

--
-- Restrições para tabelas `linkcompra`
--
ALTER TABLE `linkcompra`
  ADD CONSTRAINT `fk_linkcompra_chat` FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`);

--
-- Restrições para tabelas `mensagem`
--
ALTER TABLE `mensagem`
  ADD CONSTRAINT `fk_chatID` FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`),
  ADD CONSTRAINT `fk_mensagem_destinatario` FOREIGN KEY (`userID`) REFERENCES `usuario` (`userID`);

--
-- Restrições para tabelas `notificacao`
--
ALTER TABLE `notificacao`
  ADD CONSTRAINT `fk_notificacao_remetente` FOREIGN KEY (`null`) REFERENCES `usuario` (`userID`),
  ADD CONSTRAINT `fk_notificacao_usuario` FOREIGN KEY (`userID`) REFERENCES `usuario` (`userID`),
  ADD CONSTRAINT `notificacao_ibfk_1` FOREIGN KEY (`destinatarioID`) REFERENCES `usuario` (`userID`),
  ADD CONSTRAINT `notificacao_ibfk_2` FOREIGN KEY (`chatID`) REFERENCES `chat` (`chatID`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`categoriaID`) REFERENCES `categoria` (`categoriaID`),
  ADD CONSTRAINT `fk_produto_usuario` FOREIGN KEY (`userID`) REFERENCES `usuario` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
>>>>>>> 8dd99ddb18599ff97171806917c64fa4cb65d2ec
