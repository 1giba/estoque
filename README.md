# v1.2 - Melhorando um pouco

Em resumo, vamos retirar as operações de banco, as validações de acesso e as mensagens flash e separar em arquivos.

* Em todos os arquivos php é aberta a conexão com o banco de dados, assim foi criado o **abre_conexao.php**;
* Todas as operações SQL com o banco, foram agrupadas em **operacoes_banco.php** a fim de melhorar um pouco a organização do código;
* Podemos perceber que na maioria dos arquivos é feita a verificação se o usuário está logado, assim criamos o **verifica_acesso.php**;
* Na listagem, inserção e alteração de usuários somente o Administrador possui o acesso. Nestes arquivos já possuímos a validação, apenas criamos o **somente_admin.php** para centralizar a validação;
* Também criamos **mensagem_flash.php**, para tratar as mensagens flash geradas de erros ou sucesso.

[Veja as diferenças com a versão anterior](https://github.com/gjunior-tray/estoque/compare/v1.1...v1.2?expand=1)

[Voltar para a **master**](https://github.com/gjunior-tray/estoque/tree/master)