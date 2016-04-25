# v3.4 - Por quê utilizar o composer?

Em primeiro lugar, devemos apagar o nosso diretório Vendor. O composer irá gerenciar a biblioteca do twig.

E também utilizará o próprio autoload para carregar as classes dinamicamente.

Após isso, devemos manter apenas o README.md, o bootstrap e o index.php na raiz, e mover todo o projeto para um diretório chamado **src**.


Crie um arquivo chamado composer.json na raiz, idêntico ao abaixo:

```json
{
	"require": {
		"twig/twig": "~1.0"
	},
	"autoload" : {
	    "psr-4" : {
	        "Foo\\" : "src/"
	    }
	}
}
```

Definimos a biblioteca de dependência da nossa aplicação e definimos o nosso autoload.

Feito isso vá no shell, e instale a dependência via composer:

```sh
$ composer install
```

Pronto basta retirar os requires da aplicação e apagar o bootstrap.


[Veja as diferenças com a versão anterior](https://github.com/gjunior-tray/estoque/compare/v3.3...v3.4?expand=1)

[Voltar para a **master**](https://github.com/gjunior-tray/estoque/tree/master)