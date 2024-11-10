<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conheça a Metache</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .section {
            margin-bottom: 30px;
        }
        .highlight {
            background-color: #f9f9f9;
            border-left: 5px solid #FF6B01;
            padding: 15px;
            border-radius: 5px;
        }
        .section h2 {
            color: #FF6B01;
            font-weight: bold;
        }
        .icon {
            color: #FF6B01;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h1 class="mb-4 text-center">Conheça a Metache</h1>
    <p class="text-center text-muted">Descubra como nossa plataforma funciona e os benefícios que oferecemos para garantir uma experiência de compra e venda segura e confiável.</p>
    
    <!-- Seção de Resumo -->
    <div id="resumo" class="section <?= $section === 'resumo' ? 'highlight' : '' ?>">
        <h2><span class="icon">📄</span>Resumo da Metache</h2>
        <p>A Metache é uma plataforma inovadora que oferece um ambiente seguro e confiável para compra e venda de produtos, com uma atenção especial à segurança e ao suporte durante as transações.</p>
    </div>

    <!-- Seção sobre Venda -->
    <div id="venda" class="section <?= $section === 'venda' ? 'highlight' : '' ?>">
        <h2><span class="icon">🛒</span>Como Funciona a Venda na Metache</h2>
        <p>Para vender na Metache, os vendedores cadastrados podem anunciar seus produtos, definir preços, e aguardar que compradores interessados iniciem uma negociação. O processo de pagamento e entrega é monitorado pela plataforma, garantindo segurança para ambos os lados.</p>
    </div>      

    <!-- Seção sobre Precificação -->
    <div id="precificar" class="section <?= $section === 'precificar' ? 'highlight' : '' ?>">
        <h2><span class="icon">💰</span>Como Precificar na Metache</h2>
        <p>Defina preços competitivos e justos para os produtos que deseja vender. A Metache fornece informações sobre produtos semelhantes para ajudar os vendedores a definir valores realistas e atrativos.</p>
    </div> 

    <!-- Seção sobre Compra -->
    <div id="compra" class="section <?= $section === 'compra' ? 'highlight' : '' ?>">
        <h2><span class="icon">🔍</span>Como Funciona a Compra na Metache</h2>
        <p>Os compradores na Metache podem buscar produtos de seu interesse, iniciar uma negociação e realizar o pagamento seguro pela plataforma. O valor pago é mantido em custódia pela Metache até que o comprador receba o produto e aprove a compra.</p>
    </div>

    <!-- Seção sobre Garantias -->
    <div id="garantia" class="section <?= $section === 'garantia' ? 'highlight' : '' ?>">
        <h2><span class="icon">🔒</span>Garantias de Comprar na Metache</h2>
        <p>A Metache oferece garantia ao comprador, mantendo o valor em custódia até a conclusão do processo. Em casos de problemas ou insatisfação, o comprador pode contar com o suporte para resolver a situação antes da liberação do valor ao vendedor.</p>
    </div>

    <!-- Seção sobre o Diferencial -->
    <div id="diferencial" class="section <?= $section === 'diferencial' ? 'highlight' : '' ?>">
        <h2><span class="icon">✨</span>Nosso Diferencial: Revisão Humana</h2>
        <p>O diferencial da Metache é que todas as transações passam por uma análise feita por um membro de nossa equipe antes de serem finalizadas. Isso garante que todas as compras sejam realizadas com transparência e responsabilidade, protegendo compradores e vendedores de possíveis problemas.</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Rolar até a seção solicitada na URL
    document.addEventListener("DOMContentLoaded", function() {
        const section = "<?= $section ?>";
        const element = document.getElementById(section);
        if (element) {
            element.scrollIntoView({ behavior: "smooth", block: "start" });
        }
    });
</script>

</body>
</html>
