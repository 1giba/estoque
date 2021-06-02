# Controle de Estoque

## Objetivos:

* Criação de uma aplicação exemplo com PHP/MySQL; 
* Amostragem do desenvolvimento em fases, do procedural ao framework, para o máximo de entendimento.

**Observações:** O objetivo aqui não é criar o sistema perfeito, e sim mostrar de forma simples todas as etapas de uma evolução de um sistema.

## Sistema:

* A aplicação deverá ter administradores e funcionários como usuários e um cadastro de produtos;
* Os administradores podem cadastrar, alterar e listar todos os usuários;
* Os funcionários não tem acesso aos dados de outros usuários, apenas conseguem alterar sua senha;
* Não será possível alterar a quantidade do produto no seu cadastro ou alteração;
* A alteração da quantidade do produto deverá ser feita numa tela de baixa ou reposição de estoque;
* O histórico da movimentação do estoque ficará visível apenas na alteração do produto.

## Informativo:

No branch **master**, temos apenas o README e o script SQL do banco de dados MYSQL utilizado. 

O nome do banco é **estoque** e o collate dele é **utf8_general_ci**.

Cada branch deste repositório corresponde a 1 fase (listada logo abaixo).

Cada branch foi gerado a partir da última fase realizada em cada etapa e não do master.

## Fases:

### 1. Procedural

#### 1.1 Totalmente Procedural

**branch:** [v1.1](https://github.com/gjunior-tray/estoque/tree/v1.1)

**Info:** Início da criação do projeto totalmente procedural.

#### 1.2 Melhorando um pouco

**branch:** [v1.2](https://github.com/gjunior-tray/estoque/tree/v1.2)

**Info:** Observando as funcionalidades e separando em **functions**.

### 2. Orientação à Objetos

#### 2.1 Passando para POO

**branch:** [v2.1](https://github.com/gjunior-tray/estoque/tree/v2.1)

**Info:** Organizando as funcionalidades em classes.

#### 2.2 Herança

**branch:** [v2.2](https://github.com/gjunior-tray/estoque/tree/v2.2)

**Info:** Observando o que as classes têm em comum

### 3. MVC

#### 3.1 Aplicando MVC no projeto

**branch:** [v3.1](https://github.com/gjunior-tray/estoque/tree/v3.1)

**Info:** Separando em Model, View e Controller

#### 3.2 Usando um Template Engine

**branch:** [v3.2](https://github.com/gjunior-tray/estoque/tree/v3.2)

**Info:** Adicionando o twig no projeto

#### 3.3 Namespace

**branch:** [v3.3](https://github.com/gjunior-tray/estoque/tree/v3.3)

**Info:** Centralizando os requires no bootstrap e adicionando namespaces

#### 3.4 Por quê o composer?

**branch:** [v3.4](https://github.com/gjunior-tray/estoque/tree/v3.4)

**Info:** Adicionando o composer no projeto

### 4. Laravel

To-Do
