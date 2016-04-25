# v3.1 - MVC

Separando a aplicação em MVC, vamos colocar como exemplo o login.php.

Primeiramente devemos criar 3 diretórios: Model, View e Controller, e assim separar nossa aplicação.

### Model

No exemplo de login, vamos mover a classe Usuario.php para o diretório de Models.

A classe [**Usuario**](https://github.com/gjunior-tray/estoque/blob/v2.2/usuarios/login.php#L24) vira **model**.

### View

A view basta copiar todo o [html](https://github.com/gjunior-tray/estoque/blob/v2.2/usuarios/login.php#L49-L68) e jogar no seu diretório correspondente. Ficará assim: https://github.com/gjunior-tray/estoque/blob/v3.1/View/usuarios/login.php.

### Controller

Fará as chamadas, validações e incluirá a view. Ficará assim: 
https://github.com/gjunior-tray/estoque/blob/v3.1/Controller/UsuarioController.php

### Finalizando

Neste exemplo, foi criado a pasta **App**, onde temos:

* Aplicacao.php -> starta a nossa aplicação
* Acesso.php -> trata dos acessos (origem: https://github.com/gjunior-tray/estoque/blob/v2.2/classes/Acesso.php)
* Conexao.php -> trata da conexão (origem: https://github.com/gjunior-tray/estoque/blob/v2.2/classes/Conexao.php)
* Helper.php -> monta as novas urls
* Mensagem.php -> controla as mensagens flash (origem: https://github.com/gjunior-tray/estoque/blob/v2.2/classes/Mensagem.php)

Toda a aplicação roda em cima do [index.php](https://github.com/gjunior-tray/estoque/blob/v3.1/index.php) da raiz do projeto. É responsável por chamar todos os métodos dos controllers.

**Exemplo:**

{{ URL_DA_APP }}/index.php?controlador=usuario&metodo=login

[Veja as diferenças com a versão anterior](https://github.com/gjunior-tray/estoque/compare/v2.2...v3.1?expand=1)

[Voltar para a **master**](https://github.com/gjunior-tray/estoque/tree/master)