# lojavirtual/document-linter

Biblioteca responsável por validar a sintaxe dos documentos HTML e CSS

## Instalação
```sh
composer require lojavirtual/document-linter
```

## Docker
Para rodar o projeto utilizando o docker:
```sh
docker-compose up -d
```

## Dependências
O projeto utiliza uma abstração em java fornecida pela W3C para fazer a validação, sendo assim necessário a instalação da JRE do java na máquina onde o projeto rodará.

### Como utilizar

#### HTML
```php
<?php

use LojaVirtual\Linter;

$htmlContent = "<div>teste</div>";
$linter = Linter::HTML($htmlContent);
if (!$linter->isValid()) { // Retorna um booleano informando se o documento é valido
    var_dump($linter->getError()); // Retorna um array com todos erros encontrados
}

$rawHtmlDocument = "
    <!DOCTYPE html>
    <html>
    <head>
        <title>HTML Linter</title>
    </head>
    <body>
        <p>Test</p>
    </body>
    </html>
";
$linter = Linter::HTML($rawHtmlDocument, true);
if (!$linter->isValid()) { // Retorna um booleano informando se o documento é valido
    var_dump($linter->getError()); // Retorna um array com todos erros encontrados
}
```

#### CSS
```php
<?php

use LojaVirtual\Linter;

// Trecho de CSS puro
$cssContent = "
    <style>
    .containerInputLoginCadastro.noBorder
    {
       border:none;
    }
    
    .containerInputLoginCadastro .inputTextPadrao
    {
        width:100%;
    }
    </style>
    
    <div class="containerTermosCadastro">
            <div class="containerInputLogin">
                <div class="boxBotaoPadraoTema boxBotaoRetratil">
                    <div class="conteudoBotaoPadraoTema">
                        <p>teste</p>
                    </div>
                </div>
        </div>
    </div>
";
$linter = Linter::CSS($cssContent, true);
if (!$linter->isValid()) { // Retorna um booleano informando se o documento é valido
    var_dump($linter->getError()); // Retorna um array com todos erros encontrados
}


// Trecho de CSS dentro de um contexto HTML
$cssContent = ".teste{ color: black; }";
$linter = Linter::CSS($cssContent);
if (!$linter->isValid()) { // Retorna um booleano informando se o documento é valido
    var_dump($linter->getError()); // Retorna um array com todos erros encontrados
}```

### Padrões
Projeto segue os padrões de codificação da PSR-12.
Você antes de colaborar, verifique o comando abaixo para garantir que sua colaboração segue o mesmo padrão de projeto. 

```shell
composer cs
```

### Referências
[https://validator.github.io/validator/](https://validator.github.io/validator/)

