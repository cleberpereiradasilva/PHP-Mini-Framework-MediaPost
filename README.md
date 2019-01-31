
Configure um ambiente para rodar seu sistema com:
        Qualquer distribuição Linux;
        Um servidor web de sua escolha (de preferência nginx);
        Banco de dados MySQL/MariaDB;
        PHP 7.2+.

Integração com API

    Para começar a integração, crie uma conta teste em nosso ambiente;
    Ao acessar sua conta, requisite as chaves de integração da API através do caminho: Suporte > Meus chamados > Novo chamado.


Código

    Leve em consideração a legibilidade de seu código e boas práticas;
    Tente manter sempre o menor nível de acoplamento viável;
    Use apenas namespaces que não sejam o global em suas classes.

Criação de um "mini-framework"

    Crie um sistema de roteamento para mapear URLs para uma classe/método ("controller"). Todas as requisições devem passar por um arquivo único;
    Faça a renderização do HTML em arquivos separados do PHP;
    Crie o autoloading de seu sistema sem utilizar o composer ou outra biblioteca pronta.



Sistema

    Você precisa criar um sistema que irá utilizar nossa API (ver documentação) para:
        Criar uma lista de contatos;
        Cadastrar contatos em uma lista;
        Criar uma mensagem;
        Fazer um envio dessa mensagem para uma lista;
        Exibir os resultados de um envio.
    Crie um gateway no PHP que irá se comunicar com nossa API;

Autenticação e autorização

    Crie a funcionalidade de login para autenticação com usuário e senha via banco de dados;
    Crie uma tela para listagem e cadastro de usuários;
    Ao acessar o sistema, o usuário pode listar as mensagens que ele criou e visualizar o resultado do disparo de cada uma;
    Crie usuários com conjuntos de permissões diferentes, configurados via banco de dados (não precisa de interface para isso):
        Listar usuários;
        Cadastrar usuário;
        Cadastrar listas e contatos;
        Cadastrar mensagem;
        Enviar mensagem;
        Exibir resultados do envio.

Frontend

    Crie uma interface amigável para seu sistema, utilizando bootstrap ou outro UI Kit;
    Faça todas as requisições para seu gateway via AJAX.;
    Você pode utilizar uma biblioteca (como jQuery) para te auxiliar.

Item livre

    Exerça sua criatividade e implemente alguma funcionalidade nova nesse mini-sistema. Surpreenda-nos! (PS: esse item é obrigatório)



Explique seu sistema

    Crie um documento PDF mostrando a arquitetura de seu sistema e justifique as decisões tomadas para resolver os problemas especificados no teste, desde o item Preparação até Aplicação

Envio

	Faça o upload de seu código + arquivo de configurações do servidor web + SQL de seu banco de dados em algum sistema online de versionamento (GitHub, BitBucket, etc) e envie o link de acesso para ***********@*******. 

