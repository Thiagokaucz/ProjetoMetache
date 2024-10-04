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
