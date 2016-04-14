# v2.2 - Herança

Olhando as classes que precisam da conexão, podemos perceber que todas elas tem o mesmo atributo e o mesmo método construtor. 

## Estoque.php

```php
class Estoque
{
	/**
	 * @var mixed Objeto de Conexão gerado para o MySQL
	 */
	protected $con;

	/**
	 * Método construtor
	 *
	 * @param mixed $con
	 */
	public function __construct($con)
	{
		$this->con = $con;
	}

	/****************************/
}
```

## Produto.php

```php
class Produto
{
	/**
	 * @var mixed Objeto de Conexão gerado para o MySQL
	 */
	protected $con;

	/**
	 * Método construtor
	 *
	 * @param mixed $con
	 */
	public function __construct($con)
	{
		$this->con = $con;
	}

	/****************************/
}
```

## Usuario.php

```php
class Usuario
{
	/**
	 * @var mixed Objeto de Conexão gerado para o MySQL
	 */
	protected $con;

	/**
	 * Método construtor
	 *
	 * @param mixed $con
	 */
	public function __construct($con)
	{
		$this->con = $con;
	}

	/****************************/
}
```

O que é comum devemos jogar numa classe Pai e herdar nas filhas, criando a classe **Base.php**.

[Veja as diferenças com a versão anterior](https://github.com/gjunior-tray/estoque/compare/v2.1...v2.2?expand=1)

[Voltar para a **master**](https://github.com/gjunior-tray/estoque/tree/master)