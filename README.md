[![Latest Stable Version](https://poser.pugx.org/dersonsena/yii2-user-module/v/stable)](https://packagist.org/packages/dersonsena/yii2-user-module)
[![Total Downloads](https://poser.pugx.org/dersonsena/yii2-user-module/downloads)](https://packagist.org/packages/dersonsena/yii2-user-module)
[![Latest Unstable Version](https://poser.pugx.org/dersonsena/yii2-user-module/v/unstable)](https://packagist.org/packages/dersonsena/yii2-user-module)
[![License](https://poser.pugx.org/dersonsena/yii2-user-module/license)](https://packagist.org/packages/dersonsena/yii2-user-module)

Yii2 Deploy Module
===========================

Módulo de deploy automático no formato de Modules do Yii Framework 2. Caso você queira, que para todo comando ```git push``` no seu 
ambiente de desenvolvimento local, automaticamente atualize o seu repositório remoto, basta seguir as instruções e passos abaixo.

[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

PRÉ-REQUISITOS
-------------------
* Função nativa do PHP ```shell_exec``` habilitada no seu servidor WEB;

INSTRUÇÕES PARA INSTALAÇÃO
-------------------

A maneira recomendada para instalar esta extensão é através do [composer](http://getcomposer.org/download/).

Execute no seu terminal

```
$ php composer.phar require dersonsena/yii2-deploy "dev-master"
```

ou adicione

```
"dersonsena/yii2-deploy": "dev-master"
```

na seção ```require``` do seu arquivo `composer.json`.

PASSO 1 - REGISTRANDO MÓDULO
-------------------

Registre o módulo no arquivo de configuração ```config/web.php``` conforme o trecho abaixo:

```php
'modules' => [
    ...
    'deploy' => [
        'class' => 'dersonsena\deploy\DeployModule',
        'token' => '<INSIRA UM TOKEN AQUI>',
    ],
    ...
]
```

Você pode utilizar algumas soluções online para gerar seu token. Abaixo, alguns sites:

* [http://www.miraclesalad.com/webtools/md5.php](http://www.miraclesalad.com/webtools/md5.php)
* [http://www.md5.cz](http://www.md5.cz)
* [http://passwordsgenerator.net/md5-hash-generator/](http://passwordsgenerator.net/md5-hash-generator)

PASSO 2 - FAZENDO PRIMEIRO TESTE
-------------------

Para efeitos de teste, acesse esta URL no seu navegador: 

```
http://seudominio.com.br/deploy?t=SEU_TOKEN
```

O módulo deverá "devolver" uma tela com os comandos executados.

PASSO 3 - INTEGRAÇÃO
-------------------

Caso tenha dado tudo certo no ```PASSO 2```, siga os passos abaixo para integrar sua aplicação 

### 3.1 INTEGRAÇÃO COM BITBUCKET

1. Navegue até o endereço do seu repositório e vá na seção ```settings```;
2. Navegue até a seção ```Integrations >> Webhooks```;
3. Clique no botão ```Add Webhook```;
4. Informe um ```title``` de sua preferência;
5. No campo ```URL``` insira: http://seudominio.com.br/deploy?t=SEU_TOKEN
6. Clique no Botão ```Save```.

EXTRAS
-------------------

### ALTERANDO O BRANCH

Caso você queira que a instrução ```git pull``` utilize um outro branch, basta adicionar o parâmetro ```?b=meu-branch``` na sua URL, como abaixo:

```
http://seudominio.com.br/deploy?t=SEU_TOKEN&b=meu-branch
```

### FORÇAR EXECUÇÃO DOS COMANDOS NO AMBIENTE DE DESENVOLVIMENTO

Por padrão, o módulo Yii2-Deploy não executa os comandos gerados no ambiente de desenvolvimento. Mas, caso você queira desabilitá-lo, 
basta sobrescrever a propriedade ```forceExecuteCommands``` no seu ```config/web.php```, como abaixo:
 
```php
'modules' => [
    ...
    'deploy' => [
        'class' => 'dersonsena\deploy\DeployModule',
        'token' => '<SEU TOKEN>',
        'forceExecuteCommands' => true
    ],
    ...
]
```